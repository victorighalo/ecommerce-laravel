<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Vanilo\Framework\Models\Product;
use Vanilo\Framework\Models\Taxon;
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
        dd( Input::file("products/10926.png"));

        //Parse string input
        parse_str($request->form_data, $product_data);

        //Generate SKU
        $sku = strtoupper(substr($product_data['name'], 0, 3)) . "-" . $product_data['category_id'];

        //Create Product
        $product = Product::create([
            'name'             => $product_data['name'],
            'sku'              => $sku,
            'description'      => $product_data['description'],
            'meta_keywords'    => $product_data['tags'],
            'state'            => ProductState::ACTIVE
        ]);

        $taxon = Taxon::where('id', $product_data['category_id'])->first();

        //Add Taxon to product
        $product->addTaxon($taxon);

        //Relate images to product
        $product->addMedia($request['images'][0])->toMediaCollection('images');

    }
}
