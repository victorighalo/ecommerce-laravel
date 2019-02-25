<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Vanilo\Framework\Models\Taxon;
use Vanilo\Framework\Models\Product;
use Vanilo\Product\Models\ProductState;
class PagesController extends Controller
{
    public function getProductList($taxon_slug){
        $taxon = Taxon::findBySlug($taxon_slug);
        if($taxon) {
            $products = $taxon->products()->paginate(20)->onEachSide(2);
            $now = Carbon::now();
            return view('pages.front.product_list', compact('products', 'now'));
        }else{
            abort(404);
        }
    }

    public function getProductDetails($slug, $product){
        $taxon = Taxon::findBySlug($slug);
        $products = $taxon->products;
        return view('pages.front.product_list', compact('products'));
    }
}
