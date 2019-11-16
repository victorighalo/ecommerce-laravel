<?php


namespace App;

use Vanilo\Cart\Facades\Cart as BaseCart;
use App\CartItemVariant;
class Cart extends BaseCart
{

    public  function variants(){
        return $this->hasMany(CartItemVariant::class, 'cart_id');
    }
}
