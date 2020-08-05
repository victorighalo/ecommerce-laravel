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
        SEOMeta::setTitle(config('app.name', ''), false);
        SEOMeta::setDescription(config('app.description'). ' | '.config('app.name', ''));
        SEOMeta::setCanonical(config('app.url'));
        SEOMeta::addKeyword(config('app.keywords'));

        //Open graph
        OpenGraph::setTitle(config('app.name', ''));
        OpenGraph::setDescription(config('app.description') .' | '.config('app.name', ''));
        OpenGraph::setUrl(config('app.url'));
        OpenGraph::addImage(config('app.logo'));

        $categories = Taxon::all();

        dd(($categories->first()->products->first()->state));
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

            SEOMeta::setTitle($taxon->name . ' category | ' .config('app.name', ''), false);
            SEOMeta::setDescription('Buy original ' .$taxon->name.','.  config('app.description') .' | '.config('app.name', ''));
            SEOMeta::setCanonical(config('app.url').$taxon_slug);
            SEOMeta::addKeyword([$taxon->name. ', '.config('app.keywords')]);

            //Open graph
            OpenGraph::setTitle($taxon->name .' | '.config('app.name', ''));
            OpenGraph::setDescription('Buy original ' .$taxon->name.','.config('app.description') .' | '.config('app.name', ''));
            OpenGraph::setUrl(config('app.url').$taxon_slug);
            OpenGraph::addImage(config('app.logo'));

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


        SEOMeta::setTitle($title . ' | '.config('app.name', ''), false);
        SEOMeta::setDescription('Buy original ' .$title.',' .config('app.description') .' | '.config('app.name', ''));
        SEOMeta::setCanonical(config('app.url').$taxon_slug);
        SEOMeta::addKeyword([$title. ' ' . config('app.keywords')]);

        //Open graph
        OpenGraph::setTitle($title . ' | '.config('app.name', ''));
        OpenGraph::setDescription('Buy original ' .$title.','. config('app.description') .' .| '.config('app.name', ''));
        OpenGraph::setUrl(config('app.url').$taxon_slug);
        OpenGraph::addImage(config('app.logo'));

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

            SEOMeta::setTitle($title . ' | '.config('app.name', ''), false);
            SEOMeta::setDescription('Buy original ' .$title.',' .config('app.description') .' | '.config('app.name', ''));
            SEOMeta::setCanonical(config('app.url').$slug);
            SEOMeta::addKeyword([$title.' ' . config('app.keywords')]);

            //Open graph
            OpenGraph::setTitle($title. ' | ' .config('app.name', ''));
            OpenGraph::setDescription('Buy original ' .$title.','.  config('app.description') .' | '.config('app.name', ''));
            OpenGraph::setUrl(config('app.url').$slug);
            OpenGraph::addImage(config('app.logo'));

            return view('pages.front.products_by_brand', compact('products', 'now', 'taxon_slug', 'title', 'categories'));
        }else{
            abort(404);
        }

    }
}
