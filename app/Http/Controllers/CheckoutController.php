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
        $states = DB::table('states')->get();
        $addresses = DeliveryAddress::where('user_id', Auth::id())->get();
        $delivery_cost = 0;
        foreach (Cart::getItems() as $item){
           $delivery_cost += $item->product->delivery_cost;
        }
        $total_cost = Cart::total() + $delivery_cost;
        return view('pages.front.checkout', compact(  'states', 'addresses', 'delivery_cost', 'total_cost'));
    }

    public function checkout(CheckoutRequest $request)
    {

        Cart::destroy();
//        return view('checkout.thankyou', ['order' => $order]);
    }

    protected function userHasTempAddress(){
        return DeliveryAddress::where('session_id', session()->getId())->exists();
    }
}
