<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable =['link'];

    public function photoable(){
        return $this->morphTo();
    }

    public function getImageUrlAttribute()
    {
        if(config('app.PHOTO_DRIVER') == 'local'){
            return $this->link;
        }elseif (config('app.PHOTO_DRIVER') == 's3'){
            return "https://s3.".env('AWS_DEFAULT_REGION').".amazonaws.com/".env('AWS_BUCKET')."/images/". $this->link;
        }
    }

    public function getLocalImageUrlAttribute()
    {
            return $this->link;
    }

    public function getLocalThumbImageUrlAttribute()
    {
            return  "thumbnail/".$this->link;
    }

}
