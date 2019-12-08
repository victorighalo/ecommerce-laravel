<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{

    protected $guarded = [];
    protected $table = "product_variants";

    public static function addVariants(array $variants, $product){

        $product_variants_filtered = collect($variants)->filter( function ($item){
            return $item != null;
        });

        $array = [];
        $product_variants_filtered->each(function ($product_variants) use($product, $array) {
            foreach ($product_variants['variant_properties'] as $item) {
                $variant = (object)[
                    'product_id' => $product,
                    'option_id' => $item['property_id'],
                    'option_name' => $item['property_name'],
                    'option_value' => $item['property_value'],
                ];
                array_push($array, $variant);
            }
        });
        return $product_variants_filtered;
    }

    public function options(){
        return $this->hasMany(ProductVariantOptions::class, 'variant_id', 'id');
    }
}
