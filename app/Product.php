<?php

namespace App;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Vanilo\Contracts\Buyable;
use Vanilo\Product\Models\Product as BaseProduct;
use Vanilo\Support\Traits\BuyableModel;
use Vanilo\Support\Traits\BuyableImageSpatieV7;

class Product extends BaseProduct implements Buyable, HasMedia
{
    use BuyableModel; // Implements Buyable methods for common Eloquent models
    use BuyableImageSpatieV7; // Implements Buyable's image methods using Spatie Media Library
    use HasMediaTrait; // Spatie package's default trait
}