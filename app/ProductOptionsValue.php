<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductOptionsValue extends Model
{

    protected $table = "product_options_values";

    protected $guarded = [];

    public function scopeSort($query)
    {
        return $query->orderBy('value');
    }
}
