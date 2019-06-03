<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Vanilo\Cart\Facades\Cart;
use App\Taxon;

class SearchController extends Controller
{

    public function searchProduct(){
        $title = $q = Input::get ( 'product' );
        if (str_word_count($title) < 1){
            return back();
        }
        $query = \App\Product::where([
            ['name', 'LIKE', '%' . $title . '%'],
        ]);

        $cart_count = Cart::itemCount();

        $categories = Taxon::all();
            $products = $query->paginate(20)->onEachSide(2);
            return view('pages.front.search', compact( 'categories', 'products','cart_count', 'title'));
    }
}
