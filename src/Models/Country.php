<?php

namespace Indianiic\Country\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Country extends Model implements HasMedia {

     use HasMediaTrait;
    protected $guarded = ['id'];

    public function getFlagUrlAttribute() {
        $filePath = env('MEDIA_DISK') == 's3' ? \Storage::disk(env('MEDIA_DISK'))->exists($this->getFirstMediaPath('flags')) : file_exists($this->getFirstMediaPath('flags'));
        if ($filePath) {
            return $this->getFirstMedia('flags')->getFullUrl();
        }
        return asset('images/placeholder-profile.jpg');
    }
}
