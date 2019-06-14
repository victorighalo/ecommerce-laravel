<?php

namespace App\Http\Controllers\Payment;


use App\Http\Requests\PaymentRequest;
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

class PaymentController extends Controller
{

    private $payStackProxy;
    public function __construct(PayStackProxy $PayStackProxy)
    {
        $this->payStackProxy = $PayStackProxy;
        $this->middleware(['web']);
    }
    
    public function initializePayStackTrans(PaymentRequest $request){
        $trans_email = Auth::guest() ? $request->email : Auth::user()->email;
        $user_id = Auth::guest() ? Auth::id() : null;
        $amount = (Cart::total() * 100);
        $uuid = bin2hex(random_bytes(10)) ;
        $ref = trim($uuid);
        $initPayStack = $this->payStackProxy->initializeTransaction($trans_email, $amount , $ref);

        if(!$initPayStack){
            return back()->with(['error' => 'Network failure. Please try again.']);
        }
        if($initPayStack->status){
            $this->createTransaction($amount, $trans_email, $user_id,$uuid, $request);
            return redirect()->away($initPayStack->data->authorization_url);
        }else{
            return back()->with(['error' => $initPayStack->message]);
        }
    }

    protected function createTransaction($amount, $trans_email,$user_id,$uuid, Request $request){

        $status = new TransactionStatus('pending');

        $trans = new Transactions();
        $trans->firstname = $request->firstname;
        $trans->lastname = $request->lastname;
        $trans->status = $status->value();
        $trans->state_id = $request->state_id;
        $trans->cart_id = Cart::model()->id;
        $trans->city_id = $request->city_id;
        $trans->phone = $request->phone;
        $trans->address = $request->address;
        $trans->additional_info = $request->additional_info;
        $trans->reference = $uuid;
        $trans->amount = $amount;
        $trans->log = "null";
        $trans->user_id = $user_id;
        $trans->user_email = $trans_email;
        $trans->save();

        return $trans->reference;
    }

    public function successReport(){
        $trans = Transactions::find(1);
        $products = CartItem::where('cart_id', $trans->cart_id)
            ->join('products', 'cart_items.product_id', 'products.id')
            ->get();
        return view('payment.success', compact('trans', 'products'));
    }
}