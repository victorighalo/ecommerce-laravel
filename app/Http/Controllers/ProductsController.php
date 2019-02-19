<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Category\Models\Taxon;
use Vanilo\Product\Models\Product;
use Vanilo\Product\Models\ProductState;
class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $categories = Taxon::all();
        return view('pages.admin.products', compact('categories'));
    }

    public function create(Request $request){
        dd($request->all());
        $sku = $request->product_name . "-" . $request->category_id;
        Product::create([
            'name'             => $request->product_name,
            'sku'              => $sku,
            'description'      => $request->description,
            'meta_keywords'    => $request->labels,
            'state'            => ProductState::ACTIVE
        ]);
    }
}
