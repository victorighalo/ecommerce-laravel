<?php

namespace App\Http\Controllers\Payment;

use App\CartItemVariant;
use App\Http\Requests\PaymentRequest;
use App\Mail\AmazonSes;
use App\Product;
use App\Transactions;
use App\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use App\Http\Proxy\PayStackProxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Vanilo\Cart\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Enums\TransactionStatus;
use Vanilo\Cart\Models\CartItem;
use Vanilo\Order\Models\Order;
use Vanilo\Order\Models\OrderItem;
use Vanilo\Order\Models\OrderStatus;


class PaymentController extends Controller
{

    private $payStackProxy;
    public function __construct(PayStackProxy $PayStackProxy)
    {
        $this->payStackProxy = $PayStackProxy;
        $this->middleware(['web']);
    }

    public function initializePayStackTrans(PaymentRequest $request){
//        dd($request->all());
        $delivery_cost = $this->calculateDelivery($request);
        $trans_email = $request->email;
//        $trans_email = Auth::guest() ? $request->email : Auth::user()->email;
        $user_id = Auth::guest() ? null : Auth::id();
        $amount = (Cart::total() + $delivery_cost) ;
        $converted_amount = ( (Cart::total() + $delivery_cost) * 100);
        $uuid = bin2hex(random_bytes(6)) ;
        $ref = strtoupper(trim($uuid));

        $initPayStack = $this->payStackProxy->initializeTransaction($trans_email, $converted_amount , $ref);

        if(!$initPayStack){
            return back()->with(['error' => 'Network unavailable. Please try again.']);
        }
        if($initPayStack->status){
            $order = Order::create([
                'number' => $ref,
                'notes' =>$request->input('additional_info'),
                'user_id' =>$user_id
            ]);

            $cart = Cart::getItems();

            foreach ($cart as $item){
                $order->items()->create([
                    'product_type' => 'App\Product',
                    'product_id'   => $item->product->id,
                    'price'        => $item->product->price,
                    'delivery_price' => $item->product->delivery_price->amount,
                    'name'         => $item->product->name,
                    'quantity'     => $item->quantity,
                    'is_variant'     => $item->product->is_variant,
                ]);
            }

            $this->createTransaction($amount, $trans_email, $user_id,$ref,$order->id, $request);

            return redirect()->away($initPayStack->data->authorization_url);
        }else{
            return back()->with(['error' => $initPayStack->message]);
        }
    }

    protected function createTransaction($amount, $trans_email,$user_id,$ref,$order_id, Request $request){

        $status = new TransactionStatus('pending');

        $trans = new Transactions();
        $trans->firstname = $request->firstname;
        $trans->lastname = $request->lastname;
        $trans->status = $status->value();
        $trans->state_id = $request->state_id;
        $trans->order_id = $order_id;
        $trans->city_id = $request->city_id;
        $trans->phone = $request->phone;
        $trans->address = $request->address;
        $trans->additional_info = $request->additional_info;
        $trans->reference = $ref;
        $trans->amount = $amount;
        $trans->log = "null";
        $trans->user_id = $user_id;
        $trans->user_email = $trans_email;
        $trans->save();

        return $trans->reference;
    }

    private function calculateDelivery(Request $request){
        $delivery_cost = 0;
        foreach (Cart::getItems() as $item){
            $delivery_cost += $item->product->delivery_price->amount * $item->quantity;
        }
        $data = \App\DeliveryCharge::where('state_id', $request->state_id)->where('city_id', $request->city_id);

        if($data->exists())
        {
            $delivery_cost += $data->first()->cost;
        }
        return $delivery_cost;
    }

    public function successReport(Request $request){
        if($request->has('reference')) {
            $ref = $request->get('reference');
            $verifyTrans = $this->payStackProxy->verifyTransaction($ref);
            if ($verifyTrans) {
                $trans_status_complete = new TransactionStatus('complete');
                if(Transactions::where('reference', $ref)->where('status', $trans_status_complete->value())->exists()){
                    $order = Order::where('number', $ref)->first();
                    $products = OrderItem::where('order_id', $order->id)
                        ->join('products', 'order_items.product_id', 'products.id')
                        ->get();
                    $trans = Transactions::where('reference', $ref)->first();
                    Order::where('number', $ref)->update(
                        ['status' => OrderStatus::COMPLETED]
                    );

                    SEOMeta::setTitle('Successful Transaction | '.config('app.name', ''), false);

                    return view('payment.success', compact('trans', 'ref', 'products'));
                }
                if(!$verifyTrans->status){
                    $message = $verifyTrans->message;
                    $trans_status = new TransactionStatus('failed');
                    Transactions::where('reference', $ref)->update(
                        ['status' => $trans_status->value()]
                    );
                    return view('payment.unsuccessful', compact('message'));
                }elseif ($verifyTrans->data->status == 'success') {
                    $order = Order::where('number', $ref)->first();
                    $products = OrderItem::where('order_id', $order->id)
                        ->join('products', 'order_items.product_id', 'products.id')
                        ->get();
                    $trans = Transactions::where('reference', $ref)->first();
                    Order::where('number', $ref)->update(
                        ['status' => OrderStatus::COMPLETED]
                    );

                    $trans_status = new TransactionStatus('complete');

                    Transactions::where('reference', $ref)->update(
                        ['status' => $trans_status->value()]
                    );
                    SEOMeta::setTitle('Successful Transaction | '.config('app.name', ''), false);

                    $cart_with_variants = [];

                    foreach (Cart::getItems() as $item){
                        $cart_with_variants[] = (Object)[
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'variants'=> $this->getCartItemVariant($item->id,$item->product_id),
                            'product'=> $item->product,
                        ];
                    }

                    Mail::to($trans->user_email)->send(new AmazonSes($ref,$trans,$cart_with_variants));
                    Cart::destroy();
                    return view('payment.success', compact('trans', 'ref', 'products'));
                }
            }
            $trans_status = new TransactionStatus('failed');

            Transactions::where('reference', $ref)->update(
                ['status' => $trans_status->value()]
            );
            return view('payment.error');
        }
        $trans_status = new TransactionStatus('failed');

        Transactions::where('reference', $request->get('trxref'))->update(
            ['status' => $trans_status->value()]
        );
        return view('payment.error');
    }


    private function getCartItemVariant($cart_item_id,$product_id){
        return CartItemVariant::where('cart_item_id', $cart_item_id)
            ->where('product_id',$product_id)
            ->get();
    }


}
