<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Framework\Models\Product;

class CartController extends BaseController
{
    public function add(Request $request){
        try {
            $product = Product::findBySlug($request->slug);
            Cart::addItem($product, $request->qty);
            return response()->json(['message' => 'Added to cart', 'data' => $product]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to add to cart']);
        }
    }
}
