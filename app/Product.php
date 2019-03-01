<?php

namespace App;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Vanilo\Contracts\Buyable;
use Vanilo\Product\Models\Product as BaseProduct;
use Vanilo\Support\Traits\BuyableModel;
use Vanilo\Support\Traits\BuyableImageSpatieV7;
use willvincent\Rateable\Rateable;

class Product extends BaseProduct implements Buyable, HasMedia
{
    use
        Rateable,
        BuyableModel,
        BuyableImageSpatieV7,
        HasMediaTrait;
}