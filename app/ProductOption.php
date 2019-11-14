<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class ProductOption extends Model
{

    protected $table = "product_options";

    public function values(): Collection
    {
        return $this->propertyValues()->get()->sort();
    }

    public function propertyValues(): HasMany
    {
        return $this->hasMany(\App\ProductOptionsValue::class, 'product_option_id', 'id');
    }
}
