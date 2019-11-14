<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Vanilo\Cart\Facades\Cart;
use App\Taxon;
use Vanilo\Category\Models\Taxonomy;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;


class PagesController extends BaseController
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function home()
    {
        SEOMeta::setTitle('Spare parts and Autos for sale in Nigeria | '.config('app.name', ''), false);
        SEOMeta::setDescription('Buy original, top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
        SEOMeta::setCanonical('https://bigstanautos.com');
        SEOMeta::addKeyword(['spare parts', 'autos for sale', 'spare parts lagos', 'spare parts nigeria']);

        //Open graph
        OpenGraph::setTitle('Spare parts and Autos for sale in Nigeria | '.config('app.name', ''));
        OpenGraph::setDescription('Buy original, top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
        OpenGraph::setUrl('http://bigstanautos.com');
        OpenGraph::addImage(asset('assets/images/big-stan-logo.png'));

        $categories = Taxon::all()->take(4);
        $brands = Taxonomy::all();
        $sliders = \App\Slider::where('name','Homepage')->exists() && \App\Slider::where('name','Homepage')->first()->status == 1 ? \App\Slider::where('name','Homepage')->first()->photos : false;

        $latest_products = \App\Product::active()->new()->get();

        return view('pages.index', compact('categories', 'latest_products', 'brands', 'sliders'));
    }

    public function getProductList($taxon_slug){

        $taxon = Taxon::findBySlug($taxon_slug);

        $categories = Taxon::all();
        if($taxon) {
            $products = $taxon->products()->paginate(30)->onEachSide(2);
            $now = Carbon::now();
            $title = $taxon->name;

            SEOMeta::setTitle($taxon->name . ' category | Spare parts and Autos for sale in Nigeria | '.config('app.name', ''), false);
            SEOMeta::setDescription('Buy original ' .$taxon->name.', top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
            SEOMeta::setCanonical('https://bigstanautos.com/'.$taxon_slug);
            SEOMeta::addKeyword([$taxon->name.'spare parts', 'autos for sale', 'spare parts lagos', 'spare parts nigeria']);

            //Open graph
            OpenGraph::setTitle($taxon->name .'Spare parts and Autos for sale in Nigeria | '.config('app.name', ''));
            OpenGraph::setDescription('Buy original ' .$taxon->name.', top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
            OpenGraph::setUrl('http://bigstanautos.com/'.$taxon_slug);
            OpenGraph::addImage(asset('assets/images/big-stan-logo.png'));

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
        $ratings = $product->ratingPercent();

//        dd($product->variants());


        SEOMeta::setTitle($title . ' | Spare parts and Autos for sale in Nigeria | '.config('app.name', ''), false);
        SEOMeta::setDescription('Buy original ' .$title.', top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
        SEOMeta::setCanonical('https://bigstanautos.com/'.$taxon_slug);
        SEOMeta::addKeyword([$title.'spare parts', 'autos for sale', 'spare parts lagos', 'spare parts nigeria']);

        //Open graph
        OpenGraph::setTitle($title .'Spare parts and Autos for sale in Nigeria | '.config('app.name', ''));
        OpenGraph::setDescription('Buy original ' .$title.', top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
        OpenGraph::setUrl('http://bigstanautos.com/'.$taxon_slug);
        OpenGraph::addImage(asset('assets/images/big-stan-logo.png'));

        return view('pages.front.single_product', compact('product', 'tags', 'ratings', 'title'));
    }

    public function profile(){
        return view('auth.profile');
    }

    public function changePassword(){
        return view('auth.change_password');
    }

    public function getBrandProducts($slug){
        $brand = Taxonomy::findBySlug($slug);

        $categories = Taxon::roots()->byTaxonomy($brand)->get();

        if($brand) {
            $now = Carbon::now();
            $title = $brand->name;

            SEOMeta::setTitle($title . ' | Spare parts and Autos for sale in Nigeria | '.config('app.name', ''), false);
            SEOMeta::setDescription('Buy original ' .$title.', top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
            SEOMeta::setCanonical('https://bigstanautos.com/'.$slug);
            SEOMeta::addKeyword([$title.'spare parts', 'autos for sale', 'spare parts lagos', 'spare parts nigeria']);

            //Open graph
            OpenGraph::setTitle($title .'Spare parts and Autos for sale in Nigeria | '.config('app.name', ''));
            OpenGraph::setDescription('Buy original ' .$title.', top quality spare parts and Autos from trusted distributors. Place your orders and inquiries today for great value across Nigeria. | '.config('app.name', ''));
            OpenGraph::setUrl('http://bigstanautos.com/'.$slug);
            OpenGraph::addImage(asset('assets/images/big-stan-logo.png'));

            return view('pages.front.products_by_brand', compact('products', 'now', 'taxon_slug', 'title', 'categories'));
        }else{
            abort(404);
        }

    }
}
