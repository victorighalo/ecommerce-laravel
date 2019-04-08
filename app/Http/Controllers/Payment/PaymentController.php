<?php

namespace App\Http\Controllers;


use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use App\Http\Proxy\PayStackProxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Vanilo\Cart\Facades\Cart;

class PaymentController extends Controller
{

    private $payStackProxy;
    public function __construct(PayStackProxy $PayStackProxy)
    {
        $this->payStackProxy = $PayStackProxy;
        $this->middleware(['web']);
    }
    
    public function initializePayStackTrans(Request $request){

        $trans_email = Auth::guest() ? $request->email : Auth::user()->email;
        $user_id = Auth::guest() ? Auth::id() : null;
        $amount = (Cart::total() * 100);
        $uuid = bin2hex(random_bytes(10)) ;
        $ref = trim($uuid);
        $initPayStack = $this->payStackProxy->initializeTransaction($trans_email, $amount , $ref);

        if($initPayStack){
//            $this->createTransaction($amount, $trans_email, $user_id,$uuid, $request);
            return redirect($initPayStack->authorization_url);
        }else{
            dd('Failed to contact Payment server');
        }
    }
    protected function createTransaction($amount, $trans_email,$user_id,$uuid, Request $request){
        $trans = new Transactions();
        $trans->firstname = $request->firstname;
        $trans->lastname = $request->lastname;
        $trans->state_id = $request->state_id;
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
}