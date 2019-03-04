<?php

namespace App;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Vanilo\Contracts\Buyable;
use Vanilo\Product\Models\Product as BaseProduct;
use Vanilo\Support\Traits\BuyableModel;
use Vanilo\Support\Traits\BuyableImageSpatieV7;
use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Vanilo\Category\Models\TaxonProxy;

class Product extends BaseProduct implements Buyable, HasMedia
{
    use
        Rateable,
        BuyableModel,
        BuyableImageSpatieV7,
        HasMediaTrait;

    public function taxons(): MorphToMany
    {
        return $this->morphToMany(
            TaxonProxy::modelClass(), 'model', 'model_taxons', 'model_id', 'taxon_id'
        );
    }
}