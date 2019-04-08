<?php

namespace App;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Vanilo\Contracts\Buyable;
use Vanilo\Product\Models\Product as BaseProduct;
use Vanilo\Properties\Traits\HasPropertyValues;
use Vanilo\Support\Traits\BuyableModel;
use Vanilo\Support\Traits\BuyableImageSpatieV7;
use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Vanilo\Category\Models\TaxonProxy;
use BrianFaust\Commentable\Traits\HasComments;

class Product extends BaseProduct implements Buyable, HasMedia
{
    use
        Rateable,
        BuyableModel,
        BuyableImageSpatieV7,
        HasComments,
        HasPropertyValues,
        HasMediaTrait;

    public function morphTypeName(): string
{
    return 'App\Product';
}

    public function taxons(): MorphToMany
    {
        return $this->morphToMany(
            TaxonProxy::modelClass(), 'model', 'model_taxons', 'model_id', 'taxon_id'
        );
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);
    }

    public function delivery_price()
    {
        return $this->morphOne('App\DeliveryPrice', 'delivery_price');
    }
}