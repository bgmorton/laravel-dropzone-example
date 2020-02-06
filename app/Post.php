<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * Set up Media Library file conversions that should occur when a media item is attached
     * Will resize images on upload before storing them - both a large size version and a thumbnail
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(512)//Define thumbnail size in pixels
            ->height(512);

        $this->addMediaConversion('large')
            ->width(1536)//Define large image size in pixels
            ->height(1536);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

}
