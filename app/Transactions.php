<?php

namespace App;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Konekt\Enum\Eloquent\CastsEnums;


class Transactions extends Model
{
    use CastsEnums;

    protected $enums = [
        'status' => TransactionStatus::class
    ];

    public function scopeComplete($query){
        return $query->orWhere('status','=', 'complete');
    }

    public function scopeDelivery($query){
        return $query->orWhere('status','=', 'pay_on_delivery');
    }

    public function scopePending($query){
        return $query->orWhere('status','=', 'pending');
    }

    public function state(){
        return $this->hasOne(State::class, 'state_id', "state_id");
    }

    public function city(){
        return $this->hasOne(City::class, 'city_id', 'city_id');
    }
}
