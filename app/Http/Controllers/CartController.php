<?php

namespace App\Http\Controllers;

use App\CartItemVariant;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Cart\Facades\Cart;
use App\Cart as CartModel;

class CartController extends BaseController
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index(){
        SEOMeta::setTitle('Cart' . ' | '.config('app.name', ''), false);
        SEOMeta::setDescription(config('app.description'). ' | '.config('app.name', ''));
        SEOMeta::setCanonical(config('app.url'));
        SEOMeta::addKeyword(config('app.keywords'));

        //Open graph
        OpenGraph::setTitle('Cart' . ' | '.config('app.name', ''));
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
            $action = null;
            $uuid = bin2hex(random_bytes(6)) ;
            $ref = strtoupper(trim($uuid));
            //check if out of stock
            if ($product->stock < 1)
                return response()->json(['message' => 'This Product is currently out of stock'],400);

            Cart::addItem($product, $request->input('qty'),[ 'attributes' => [
                'variant_code' => $this->getProductVariantCode($request->input('variant'))
            ]
            ]);
//                if ($request->has('variant') === true) {
//                    $cart_item_exists = Cart::getItems()
//                        ->where('product_id', $product->id)
//                        ->where('cart_id', '=', Cart::model()->id)
//                        ->first();
////                    dd($cart_item_exists);
//                  if ($cart_item_exists) {
//                      $product_variants = [];
//                      foreach ($request->variant as $variant) {
//                          $product_variants[] = [
//                              'option_id' => $variant['option_id'],
//                              'option_name' => $variant['option_name'],
//                              'option_value_id' => $variant['option_value_id'],
//                              'option_value_name' => $variant['option_value_name']
//                          ];
//                      }
////                      dd($cart_item_exists->id, $cart_item_exists->product_id, $product_variants);
////                        dd($this->variantItemExistsExact($cart_item_exists->id, $cart_item_exists->product_id, $product_variants));
//                      if ($this->variantItemExistsExact($cart_item_exists->id, $cart_item_exists->product_id, $product_variants) === true) {
//                          $action = 'update';
//                          //check if same variant item exists in cart already then update only quantity
//                          (new CartModel)->items()->where('id','=', $cart_item_exists->id)
//                              ->where('cart_id', '=',Cart::model()->id)
//                              ->update(['quantity'=> $request->qty]);
//
//                      }
//                      else {
//                          $action = 'new';
//                          //new variant product
//                          DB::transaction(function () use ($product, $request,$ref) {
//                              $cart_item = Cart::addItem($product, $request->qty, ['variant_id' => $ref]);
//                              $product_variants = [];
//                              foreach ($request->variant as $variant) {
//                                  $product_variants[] = [
//                                      'product_id' => $product->id,
//                                      'cart_item_id' => $cart_item->id,
//                                      'option_id' => $variant['option_id'],
//                                      'option_name' => $variant['option_name'],
//                                      'option_value_id' => $variant['option_value_id'],
//                                      'option_value_name' => $variant['option_value_name']
//                                  ];
//                              }
//                              CartItemVariant::insert($product_variants);
//                          });
//                      }
//                  }else{
//                      $action = 'new last';
//                      //new variant product
//                      DB::transaction(function () use ($product, $request,$ref) {
//                          $cart_item = Cart::addItem($product, $request->qty, ['variant_id' => $ref]);
//                          $product_variants = [];
//                          foreach ($request->variant as $variant) {
//                              $product_variants[] = [
//                                  'product_id' => $product->id,
//                                  'cart_item_id' => $cart_item->id,
//                                  'option_id' => $variant['option_id'],
//                                  'option_name' => $variant['option_name'],
//                                  'option_value_id' => $variant['option_value_id'],
//                                  'option_value_name' => $variant['option_value_name']
//                              ];
//                          }
//                          CartItemVariant::insert($product_variants);
//                      });
//                  }
//                }else{
//                    $action = 'non variant';
//                    CartModel::addItem($product, $request->qty);
//                }

            return response()->json([
                'message' => 'Added to cart',
                'cart_count' => Cart::itemCount(),
                    'action'=>$action
                ]
            );
        }catch (\Exception $e){
//            $item = CartModel::model()->items->last();
//            CartModel::removeItem($item);
            return response()->json(['message' => 'Failed to add to cart', 'reason' => $e->getMessage()],400);
        }
    }

    private function variantItemExists($cart_item_id,$product_id){
            return CartItemVariant::where([
                ['cart_item_id', '=', $cart_item_id],
                ['product_id' , '=', $product_id]
            ])
                ->exists();
    }

    private function variantItemExistsExact($cart_item_id,$product_id,$product_variants){
        $exists = false;
        $count = 0;
        foreach ($product_variants as $product_variant){
            $check = CartItemVariant::where([
                ['cart_item_id', '=', $cart_item_id],
                ['product_id', '=', $product_id],
                ['option_id' , '=', $product_variant['option_id'] ],
                ['option_value_id' , '=', $product_variant['option_value_id'] ],
            ])
                ->exists();
            if ($check){
                $count++;
            }
        }
        if (count($product_variants) == $count)
            $exists = true;

        return $exists;
    }

    private function getProductVariantCode($variants){
        $product_variants = "";
        foreach ($variants as $index => $variant) {
            $product_variants .= $variant['option_id'] .":". $variant['option_value_id'];
            count($variants) > 1 && $index+1 < count($variants)? $product_variants .= "|" : "";
        }
        return $product_variants;
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
//        $cart_items = Cart::getItems()->where('id', $cart_item);
        Cart::removeItem($cart_item);
//        if($this->cartItemIsVariant($cart_item->id, $cart_item->product->id)){
//            CartItemVariant::where('cart_item_id', $cart_item);
//        }

        return response()->json(['message'=>$cart_item->getBuyable()->getName(). ' has been removed from cart', 'data'=>$cart_item]);
    }
}
