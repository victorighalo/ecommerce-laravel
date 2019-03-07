<?php

namespace App\Http\Controllers;

use App\DeliveryAddress;
use Illuminate\Http\Request;
use Vanilo\Cart\Facades\Cart;
use DB;
class CheckoutController extends Controller
{
    public function index(){
        if(Cart::exists()){
            $cart_count = Cart::itemCount();
            $cart = Cart::getItems();
        }else{
            $cart_count = 0;
        }
        $states = DB::table('states')->get();
        $addresses = DeliveryAddress::where('user_id', Auth::id())->get();
        return view('pages.front.checkout', compact('cart_count', 'cart', 'states', 'addresses'));
    }
}
