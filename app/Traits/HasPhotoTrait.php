<?php

namespace App\Traits;


trait HasPhotoTrait
{
    public $S3URL = " 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' ";

    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }

    public function hasPhoto(){
        return count($this->photos) ? true  : false;
    }

    public function getFirstImageAttribute(){
            return $this->hasPhoto() ? $this->photos()->first()->link : "";
    }

    public function getFirstImageS3Attribute(){
            return $this->hasPhoto() ? $this->S3URL. $this->photos()->first()->link : "";
    }

    public function getFirstThumbAttribute(){
            return $this->hasPhoto() ? "thumbnail/".$this->photos()->first()->link : "";
    }

    public function getFirstThumbS3Attribute(){
            return $this->hasPhoto() ? $this->S3URL."thumb/".$this->photos()->first()->link : "";
    }

    public function removePhoto($id, $itemId){
        $this->photos()->where('id', $id)->where('photoable_id', $itemId)->delete();
    }
}