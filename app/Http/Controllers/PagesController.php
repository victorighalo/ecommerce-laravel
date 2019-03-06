<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Framework\Models\Taxon;

class PagesController extends BaseController
{
    public function getProductList($taxon_slug){
        if(Cart::exists()){
            $cart_count = Cart::itemCount();
        }else{
            $cart_count = 0;
        }
        $taxon = Taxon::findBySlug($taxon_slug);
        if($taxon) {
            $products = $taxon->products()->paginate(20)->onEachSide(2);
            $now = Carbon::now();
            return view('pages.front.product_list', compact('products', 'now', 'cart_count'));
        }else{
            abort(404);
        }
    }

    public function getProductDetails($taxon_slug, $product_slug){
        if(Cart::exists()){
            $cart_count = Cart::itemCount();
        }else{
            $cart_count = 0;
        }
        $product = \App\Product::where('slug', $product_slug)->first();
        $tags = $product->meta_keywords ? explode(",", $product->meta_keywords) : null;
        $ratings = $product->averageRating() ;
        return view('pages.front.product_detail', compact('product', 'tags', 'ratings', 'cart_count'));
    }
}
