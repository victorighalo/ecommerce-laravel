<?php

namespace App\Http\Controllers;

use App\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vanilo\Cart\Facades\Cart;
use DB;
use Vanilo\Checkout\Facades\Checkout;
use Vanilo\Order\Contracts\OrderFactory;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function index(){

        if(Cart::isNotEmpty()){
            $cart_count = Cart::itemCount();
            $cart = Cart::getItems();

        }else{
            $cart_count = 0;
        }
        $states = DB::table('states')->get();
        $addresses = DeliveryAddress::where('user_id', Auth::id())->get();
        return view('pages.front.checkout', compact('cart_count', 'cart', 'states', 'addresses'));
    }

    public function checkout(CheckoutRequest $request, OrderFactory $orderFactory)
    {
        $checkout = Checkout::getFacadeRoot();
        $checkout->update($request->all());
        $checkout->setCart(Cart::model());
        $order = $orderFactory->createFromCheckout($checkout);
        Cart::destroy();
        dd($order);
//        return view('checkout.thankyou', ['order' => $order]);
    }

    protected function userHasTempAddress(){
        return DeliveryAddress::where('session_id', session()->getId())->exists();
    }
}
