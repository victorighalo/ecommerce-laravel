<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Cart\Contracts\CartItem;

class CartController extends BaseController
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index(){
            $cart_count = Cart::itemCount();
            $cart = Cart::getItems();
        return view('pages.front.cart', compact('cart', 'cart_count'));
    }

    public function add(Request $request){
        try {
            $product = \App\Product::findBySlug($request->slug);
            Cart::addItem($product, $request->qty);
            return response()->json(['message' => 'Added to cart', 'cart_count' => Cart::itemCount(),
                'extra' => Cart::getItems()]);
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
