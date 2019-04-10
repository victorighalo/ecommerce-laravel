<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Vanilo\Cart\Facades\Cart;
use App\Taxon;

class PagesController extends BaseController
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function home()
    {
        
        if(Cart::exists()){
            $cart_count = Cart::itemCount();
        }else{
            $cart_count = 0;
        }

        $categories = Taxon::all()->take(12);
        $latest_products = \App\Product::active()->new()->get();

        return view('pages.index', compact('categories', 'cart_count', 'latest_products'));
    }

    public function getProductList($taxon_slug){
        $taxon = Taxon::findBySlug($taxon_slug);
        $categories = Taxon::all();
        if($taxon) {
            $products = $taxon->products()->paginate(30)->onEachSide(2);
            $now = Carbon::now();
            $title = $taxon->name;
            return view('pages.front.products_by_category', compact('products', 'now', 'taxon_slug', 'title', 'categories'));
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
        $slug = $product_slug;
        $product = \App\Product::where('slug', $product_slug)->first();
        $title = $product ? $product->title() : '';
        $tags = $product->meta_keywords ? explode(",", $product->meta_keywords) : null;
        $ratings = $product->averageRating() ;
        return view('pages.front.single_product', compact('product', 'tags', 'ratings', 'cart_count', 'title'));
    }
}
