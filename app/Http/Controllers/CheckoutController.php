<?php

namespace App\Http\Controllers;

use App\DeliveryAddress;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vanilo\Cart\Facades\Cart;
use DB;
use Vanilo\Checkout\Facades\Checkout;
use Vanilo\Order\Contracts\OrderFactory;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    private $description = "Shop online for your fashion items, computer, phone and accessories, household appliances and electronics? Health and Beauty, Baby products and lots more. Quality Guaranteed.";
    private $title = "Checkout - M&M Store online shopping made easy in Nigeria";
    private $keywords = "'Polo Tops', 'Men\’s Shirts', 'Female Shirts', 'Jeans', 'Chinos', 'Track Suits', 'Joggers', 'Shorts', 'T-Shirts', 'Mobile Phones Accessories', 'Mobile phone chargers', 'Power Banks'. 'TVs', 'Home Theater'";

    public function index(){
        SEOMeta::setTitle($this->title . ' | '.config('app.name', ''), false);
        SEOMeta::setDescription($this->description. ' | '.config('app.name', ''));
        SEOMeta::setCanonical('https://mandmonlinestore.com');
        SEOMeta::addKeyword([$this->keywords]);

        //Open graph
        OpenGraph::setTitle($this->title . ' | '.config('app.name', ''));
        OpenGraph::setDescription($this->description .' | '.config('app.name', ''));
        OpenGraph::setUrl('http://mandmonlinestore.com');
        OpenGraph::addImage(asset('assets/images/big-stan-logo.png'));
        $states = DB::table('states')->get();
        $addresses = DeliveryAddress::where('user_id', Auth::id())->get();
        $delivery_cost = 0;
        foreach (Cart::getItems() as $item){
           $delivery_cost += $item->product->delivery_price->amount;
        }
        $total_cost = Cart::total() + $delivery_cost;

        return view('pages.front.checkout', compact(  'states', 'addresses', 'delivery_cost', 'total_cost'));
    }

    public function checkout(CheckoutRequest $request)
    {

        Cart::destroy();
//        return view('checkout.thankyou', ['order' => $order]);
    }

    protected function userHasTempAddress(){
        return DeliveryAddress::where('session_id', session()->getId())->exists();
    }
}
