<?php

namespace App\Traits;


trait HasPhotoTrait
{


    protected function s3ThumbUrl(){
        return "https://s3.".env('AWS_DEFAULT_REGION').".amazonaws.com/".env('AWS_BUCKET')."/images/thumbnail/";
    }

    protected function s3Url(){
        return "https://s3.".env('AWS_DEFAULT_REGION').".amazonaws.com/".env('AWS_BUCKET')."/images/";
    }
    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }

    public function hasPhoto(){
        return count($this->photos) ? true  : false;
    }

    public function getFirstImageAttribute(){
        if(config('app.PHOTO_DRIVER') == 'local'){
            return $this->hasPhoto() ? $this->photos()->first()->link : "";
        }elseif (config('app.PHOTO_DRIVER') == 's3'){
            return $this->hasPhoto() ? $this->s3Url(). $this->photos()->first()->link : "";
        }

    }

    public function getFirstThumbAttribute(){
        if(config('app.PHOTO_DRIVER') == 'local'){
            return $this->hasPhoto() ? "thumbnail/".$this->photos()->first()->link : "";
        }elseif (config('app.PHOTO_DRIVER') == 's3'){
            return $this->hasPhoto() ? $this->s3ThumbUrl().$this->photos()->first()->link : "";
        }

    }

    public function removePhoto($id, $itemId){
        $this->photos()->where('id', $id)->where('photoable_id', $itemId)->delete();
    }
}