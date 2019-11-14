<?php


namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Variants
{

    public function addVariants(array $variants, $product){

        $product_variants = collect($variants)->filter( function ($item){
            return $item != null;
        });

        $array = [];
        $variants->each(function ($product_variants) use($product) {
            foreach ($product_variants['variant_properties'] as $item) {
                $array[] = [
                    'product_id' => $product,
                    'option_id' => $item['property_id'],
                    'option_name' => $item['property_name'],
                    'option_value' => $item['property_value'],
                ];
            }
        });
        return $array;
    }
}
