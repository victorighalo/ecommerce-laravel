<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryPrice extends Model
{
    protected $fillable =['amount'];
    public function delivery_price()
    {
        return $this->morphTo();
    }
}
