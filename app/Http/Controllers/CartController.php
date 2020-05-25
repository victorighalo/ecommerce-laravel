<?php

namespace App\Http\Controllers;

use App\CartItemVariant;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Cart\Contracts\CartItem;

class CartController extends BaseController
{
    private $description = "Shop online for your fashion items, computer, phone and accessories, household appliances and electronics? Health and Beauty, Baby products and lots more. Quality Guaranteed.";
    private $title = "Cart - M&M Store online shopping made easy in Nigeria";
    private $keywords = "'Polo Tops', 'Men\’s Shirts', 'Female Shirts', 'Jeans', 'Chinos', 'Track Suits', 'Joggers', 'Shorts', 'T-Shirts', 'Mobile Phones Accessories', 'Mobile phone chargers', 'Power Banks'. 'TVs', 'Home Theater'";

    public function __construct()
    {
        $this->middleware('web');
    }

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
            $cart_count = Cart::itemCount();
            $cart = Cart::getItems();
            $cart_with_variants = [];
        //Build cart
        foreach ($cart as $item){
            $cart_with_variants[] = (object)[
              'id' => $item->id,
              'product_id' => $item->product_id,
              'quantity' => $item->quantity,
              'price' => $item->price,
              'variants'=> $this->getCartItemVariant($item->id,$item->product_id),
              'product'=> $item->product,
            ];
        }
//        dd($cart_with_variants[0]['product']->FirstImage);
//        dd($cart[0]->product);
        $cart = collect($cart_with_variants);

        return view('pages.front.cart', compact('cart', 'cart_count'));
    }

    private function getCartItemVariant($cart_item_id,$product_id){
        return CartItemVariant::where('cart_item_id', $cart_item_id)
            ->where('product_id',$product_id)
            ->get();
    }

    public function add(Request $request){

        try {
            $product = \App\Product::findBySlug($request->slug);

            DB::transaction(function () use ($product,$request) {
                $cart = Cart::addItem($product, $request->qty);
                if($this->cartItemIsVariant($cart->id, $product->id)){
                    foreach ($request->variant as $variant) {
                        $product_variants = [
//                            'option_id' => $variant['option_id'],
                            'option_name' => $variant['option_name'],
                            'option_value_id' => $variant['option_value_id'],
                            'option_value_name' => $variant['option_value_name']
                        ];
                        CartItemVariant::where('cart_item_id', $cart->id)
                            ->where('product_id',$product->id)
                            ->where('option_id',$variant['option_id'])
                            ->update($product_variants);
                    }

                }else {
                    $product_variants = [];
                    foreach ($request->variant as $variant) {
                        $product_variants[] = [
                            'product_id' => $product->id,
                            'cart_item_id' => $cart->id,
                            'option_id' => $variant['option_id'],
                            'option_name' => $variant['option_name'],
                            'option_value_id' => $variant['option_value_id'],
                            'option_value_name' => $variant['option_value_name']
                        ];
                    }
                    CartItemVariant::insert($product_variants);
                }

            });
            return response()->json(['message' => 'Added to cart', 'cart_count' => Cart::itemCount(),
                'extra' => Cart::getItems()]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to add to cart', 'reason' => $e->getMessage()],400);
        }
    }

    private function cartItemIsVariant($cart_item_id,$product_id){
        return CartItemVariant::where('cart_item_id', $cart_item_id)->where('product_id',$product_id)->exists();
    }

    public function update(CartItem $cart_item, Request $request){
        try {
//            $cart_item = Cart::getItems()->where('id', 7);

            $cart_item->quantity = $request->qty;
            $cart_item->save();
            return response()->json($cart_item);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function destroy(CartItem $cart_item)
    {
        Cart::removeItem($cart_item);
        return response()->json($cart_item->getBuyable()->getName(). ' has been removed from cart');
    }
}
