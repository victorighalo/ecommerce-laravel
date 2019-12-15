<?php

namespace App\Http\Controllers;

use App\CartItemVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Cart\Contracts\CartItem;

class CartController extends BaseController
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index(){
            $cart_count = Cart::itemCount();
            $cart = Cart::getItems();
            $cart_with_variants = [];
        //Build cart
        foreach ($cart as $item){
            $cart_with_variants[] = [
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
        $cart = $cart_with_variants;
        return view('pages.front.cart', compact('cart', 'cart_count'));
    }

    private function getCartItemVariant($cart_item_id,$product_id){
        return CartItemVariant::where('cart_item_id', $cart_item_id)
            ->where('product_id',$product_id)
            ->get();
    }

    public function add(Request $request){

        try {
            $product = \App\Product::findBySlug($request->slug)->first();
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
