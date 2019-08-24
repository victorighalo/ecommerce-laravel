<?php

namespace App\Http\Controllers\Payment;

use App\Http\Requests\PaymentRequest;
use App\Product;
use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use App\Http\Proxy\PayStackProxy;
use Illuminate\Support\Facades\Auth;
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

        $delivery_cost = $this->calculateDelivery($request);
        $trans_email = Auth::guest() ? $request->email : Auth::user()->email;
        $user_id = Auth::guest() ? Auth::id() : null;
        $amount = (Cart::total() + $delivery_cost) ;
        $converted_amount = ( (Cart::total() + $delivery_cost) * 100);
        $uuid = bin2hex(random_bytes(4)) ;
        $ref = strtoupper(trim($uuid));
        $order = Order::create([
            'number' => $ref
        ]);
        $cart = Cart::getItems();

        foreach ($cart as $item){
            $order->items()->create([
                'product_type' => 'App\Product',
                'product_id'   => $item->product->id,
                'price'        => $item->product->price,
                'name'         => $item->product->name,
                'quantity'     => 1,
            ]);

        }

        $initPayStack = $this->payStackProxy->initializeTransaction($trans_email, $amount , $ref);

        if(!$initPayStack){
            return back()->with(['error' => 'Network failure. Please try again.']);
        }
        if($initPayStack->status){
            $this->createTransaction($amount, $trans_email, $user_id,$ref,$order->id, $request);
            Cart::destroy();
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
            $delivery_cost += $item->product->delivery_price->amount;
        }
        $data = \App\DeliveryCharge::where('state_id', $request->state_id)->where('city_id', $request->city_id);

        if($data->exists())
        {
            $delivery_cost += $data->first()->cost;
        }
        return $delivery_cost;
    }
    public function successReport(Request $request){
        $ref = $request->get('reference');
        $order = Order::where('number', $ref)->first();
        $products = OrderItem::where('order_id', $order->id)
            ->join('products', 'order_items.product_id', 'products.id')
            ->get();
        $trans = Transactions::where('reference', $ref)->first();
        Order::where('number', $ref)->update(
            ['status' => OrderStatus::COMPLETED]
        );

        $trans_status = new TransactionStatus();

        Transactions::where('reference', $ref)->update(
            ['status' => $trans_status::COMPLETE]
        );

        return view('payment.success', compact('trans','ref', 'products'));
    }
}
