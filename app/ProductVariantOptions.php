<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductVariantOptions extends Model
{
protected $table = "product_variants_options";
protected $fillable = ['product_id', 'variant_id'];

}
