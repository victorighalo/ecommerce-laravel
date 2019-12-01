<?php

namespace App;

use App\ProductOption;
use App\Traits\HasPhotoTrait;
use Illuminate\Support\Str;
use Vanilo\Contracts\Buyable;
use Vanilo\Product\Models\Product as BaseProduct;
use Vanilo\Properties\Traits\HasPropertyValues;
use Vanilo\Support\Traits\BuyableModel;
use Vanilo\Support\Traits\BuyableImageSpatieV7;
use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Vanilo\Category\Models\TaxonProxy;
use BrianFaust\Commentable\Traits\HasComments;
use App\ProductVariantOptions;

class Product extends BaseProduct implements Buyable
{
    use
        Rateable,
        BuyableModel,
        BuyableImageSpatieV7,
        HasComments,
        HasPropertyValues,
        HasPhotoTrait;

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


    public function delivery_price()
    {
        return $this->morphOne('App\DeliveryPrice', 'delivery_price');
    }

    public function cartItemVariant(){
        return $this->hasMany(CartItemVariant::class, 'product_id', 'id');
    }

    public function variantOptions(){
        return $this->hasMany(ProductVariantOptions::class, 'product_id', 'id');
    }


    public function variants(){
        $product_variant_options = ProductVariantOptions::where('product_id', $this->id)
            ->join('product_options','product_variants_options.option_id', '=', 'product_options.id')
            ->join('product_options_values','product_variants_options.option_value_id', '=', 'product_options_values.id')
            ->select('product_options.id as product_options_id','option_id', 'option_name', 'option_value', 'option_value_id')
            ->get();

        $options = ProductOption::all();
        $variants = [];
        foreach($options->toArray() as $item){
            $variants[] = [
                'option_name' => $item['name'],
                'option_slug' => $item['slug'],
                'option_id' => $item['id'],
                'option_values' => []
            ];
        };

        foreach($variants as $index => $variant_option){
            $temp_option_values = [];
            foreach($product_variant_options->toArray() as $product_variant) {
                if($product_variant['product_options_id'] == $variant_option['option_id']){
                    if($this->hasOption($variants[$index]['option_values'], $product_variant['option_value_id'])){

                    }else{
                        $temp_option_values = [
                            'option_value_name' => $product_variant['option_value'],
                            'option_value_id' => $product_variant['option_value_id']
                        ];
                        array_push($variants[$index]['option_values'], $temp_option_values);
                    }

                }
            }


        };


        return collect($variants);
    }

    private function hasOption($array, $check_value){
        $status = false;
        foreach($array as $item){
            if($item['option_value_id'] == $check_value){
                $status = true;
            }
        }
        return $status;
    }

    public function scopeNew($query){
        return $query->latest()->take(20);
    }

    public function scopeActive($query){
        return $query->where('state', 'active');
    }

    public function addVariant($price,$taxon){
       return \App\ProductVariant::create(
       [
           'product_id' => $this->id,
       'sku' => strtoupper(substr($this->name, 0, 3)) . "-" . $taxon,
       'price' => $price
            ]
        );

    }

    public function addVariantOption($option,$variant_id){
        $product_variant_option = new \App\ProductVariantOptions();
        $product_variant_option->product_id = $this->id;
        $product_variant_option->option_id = $option->option_id;
        $product_variant_option->option_name = $option->option_name;
        $product_variant_option->option_value = $option->option_value;
        $product_variant_option->option_value_id = $option->option_value_id;
        $product_variant_option->variant_id = $variant_id;
        $product_variant_option->save();

    }
}
