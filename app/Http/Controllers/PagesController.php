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
        $categories = Taxon::all()->take(12);

        $latest_products = \App\Product::active()->new()->get();

        return view('pages.index', compact('categories', 'latest_products'));
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
        if(! \App\Product::where('slug', $product_slug)->exists() ){
            abort(404);
        }
        $product = \App\Product::where('slug', $product_slug)->first();
        $title = $product ? $product->title() : '';
        $tags = $product->meta_keywords ? explode(",", $product->meta_keywords) : null;
        $ratings = $product->averageRating() ;
        return view('pages.front.single_product', compact('product', 'tags', 'ratings', 'title'));
    }

    public function profile(){
        return view('auth.profile');
    }

    public function changePassword(){
        return view('auth.change_password');
    }
}
