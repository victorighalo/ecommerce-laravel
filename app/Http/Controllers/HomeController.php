<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Framework\Models\Taxon;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Cart::exists()){
            $cart_count = Cart::itemCount();
        }else{
            $cart_count = 0;
        }

        $categories = Taxon::all();
        return view('pages.index', compact('categories', 'cart_count'));
    }


}
