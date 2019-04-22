<?php

namespace App;

use App\Traits\HasPhotoTrait;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable =['link'];

    public function photoable(){
        return $this->morphTo();
    }

    public function getImageUrlAttribute()
    {
        return $this->link;
    }
}
