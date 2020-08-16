<?php

namespace App\Http\Controllers;

use App\CartItemVariant;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanilo\Cart\Facades\Cart;

class CartController extends BaseController
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index(){
        SEOMeta::setTitle('Checkout' . ' | '.config('app.name', ''), false);
        SEOMeta::setDescription(config('app.description'). ' | '.config('app.name', ''));
        SEOMeta::setCanonical(config('app.url'));
        SEOMeta::addKeyword(config('app.keywords'));

        //Open graph
        OpenGraph::setTitle('Checkout' . ' | '.config('app.name', ''));
        OpenGraph::setDescription(config('app.description') .' | '.config('app.name', ''));
        OpenGraph::setUrl(config('app.url'));
        OpenGraph::addImage(config('app.logo'));
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
            if ($product->stock < 1)
                return response()->json(['message' => 'This Product is currently out of stock'],400);

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
//                    $product_variants = [];
//                    foreach ($request->variant as $variant) {
//                        $product_variants[] = [
//                            'product_id' => $product->id,
//                            'cart_item_id' => $cart->id,
//                            'option_id' => $variant['option_id'],
//                            'option_name' => $variant['option_name'],
//                            'option_value_id' => $variant['option_value_id'],
//                            'option_value_name' => $variant['option_value_name']
//                        ];
//                    }
//                    CartItemVariant::insert($product_variants);
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

    public function update($cart_item, Request $request){
        try {
//            $cart_item = Cart::getItems()->where('id', 7);

            $cart_item->quantity = $request->qty;
            $cart_item->save();
            return response()->json($cart_item);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function destroy($cart_item)
    {
        Cart::removeItem($cart_item);
        return response()->json($cart_item->getBuyable()->getName(). ' has been removed from cart');
    }
}
