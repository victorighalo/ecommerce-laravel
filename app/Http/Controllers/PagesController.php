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
    private $description = "Shop online for your fashion items, computer, phone and accessories, household appliances and electronics? Health and Beauty, Baby products and lots more. Quality Guaranteed.";
    private $title = "M&M Store online shopping made easy in Nigeria";
    private $keywords = "'Polo Tops', 'Men\’s Shirts', 'Female Shirts', 'Jeans', 'Chinos', 'Track Suits', 'Joggers', 'Shorts', 'T-Shirts', 'Mobile Phones Accessories', 'Mobile phone chargers', 'Power Banks'. 'TVs', 'Home Theater'";
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

            SEOMeta::setTitle($taxon->name . ' category | ' .$this->title . ' | '.config('app.name', ''), false);
            SEOMeta::setDescription('Buy original ' .$taxon->name.','.  $this->description .' | '.config('app.name', ''));
            SEOMeta::setCanonical(config('app.url').$taxon_slug);
            SEOMeta::addKeyword([$taxon->name. ', '.$this->keywords]);

            //Open graph
            OpenGraph::setTitle($taxon->name .'M&M Store online shopping made easy in Nigeria | '.config('app.name', ''));
            OpenGraph::setDescription('Buy original ' .$taxon->name.','.$this->description .' | '.config('app.name', ''));
            OpenGraph::setUrl('http://mandmonlinestore.com/'.$taxon_slug);
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


        SEOMeta::setTitle($title . ' | '.$this->title . ' | '.config('app.name', ''), false);
        SEOMeta::setDescription('Buy original ' .$title.',' .$this->description .' | '.config('app.name', ''));
        SEOMeta::setCanonical('https://mandmonlinestore.com/'.$taxon_slug);
        SEOMeta::addKeyword([$title. ' ' . $this->keywords]);

        //Open graph
        OpenGraph::setTitle($title . ' | '. $this->title . ' | '.config('app.name', ''));
        OpenGraph::setDescription('Buy original ' .$title.','. $this->description .' .| '.config('app.name', ''));
        OpenGraph::setUrl('http://mandmonlinestore.com/'.$taxon_slug);
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

            SEOMeta::setTitle($title . ' | ' .$this->title . ' | '.config('app.name', ''), false);
            SEOMeta::setDescription('Buy original ' .$title.',' .$this->description .' | '.config('app.name', ''));
            SEOMeta::setCanonical('https://mandmonlinestore.com/'.$slug);
            SEOMeta::addKeyword([$title.' ' . $this->keywords]);

            //Open graph
            OpenGraph::setTitle($title. ' | ' .$this->title . ' | '.config('app.name', ''));
            OpenGraph::setDescription('Buy original ' .$title.','.  $this->description .' | '.config('app.name', ''));
            OpenGraph::setUrl('http://mandmonlinestore.com/'.$slug);
            OpenGraph::addImage(asset('assets/images/big-stan-logo.png'));

            return view('pages.front.products_by_brand', compact('products', 'now', 'taxon_slug', 'title', 'categories'));
        }else{
            abort(404);
        }

    }
}
