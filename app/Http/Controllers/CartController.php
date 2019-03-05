<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Framework\Models\Product;

class CartController extends BaseController
{

    public function index(){

        if(Cart::exists()){
            $cart_count = Cart::itemCount();
            $cart = Cart::model()->items;
        }else{
            $cart_count = 0;
            $cart = [];
        }



        return view('pages.front.cart', compact('cart', 'cart_count'));
    }

    public function add(Request $request){
        try {
            $product = Product::findBySlug($request->slug);
            Cart::addItem($product, $request->qty);
            return response()->json(['message' => 'Added to cart', 'cart_count' => Cart::itemCount()]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to add to cart']);
        }
    }


    public function update(CartItem $cart_item, Request $request){
        try {
//            $cart_item = Cart::getItems()->where('id', 7);

            $cart_item->quantity = $request->qty;
            $cart_item->save();
            return response()->json($cart_item);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }


    public function destroy(CartItem $cart_item)
    {
        Cart::removeItem($cart_item);
        return response()->json($cart_item->getBuyable()->getName(). ' has been removed from cart');
    }
}
