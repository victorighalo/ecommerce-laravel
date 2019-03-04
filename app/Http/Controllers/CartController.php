<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Framework\Models\Product;

class CartController extends BaseController
{

    public function index(){

        if(Cart::exists()){
            $cart_count = Cart::itemCount();
        }else{
            $cart_count = 0;
        }

        $cart = Cart::model()->items;

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

    public function destroy($slug){
        try {
            $product = Product::findBySlug($slug);
            Cart::removeProduct($product);

            return back()->with('status', 'Item removed from cart!');
        }catch (\Exception $e){
            return back()->with('error', 'Failed to delete cart item!');
        }
    }
}
