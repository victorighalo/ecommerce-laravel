<?php

namespace App;

use Vanilo\Framework\Models\Product as BaseProduct;
use willvincent\Rateable\Rateable;
class Product extends BaseProduct
{
    use Rateable;
}