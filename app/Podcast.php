<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Purifier;
use Storage;

class Podcast extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function episode()
    {
        return $this->hasOne(Episode::class);
    }

    public function getArtworkImagePath()
    {
        $orginalAssetUrl=Storage::disk('doSpaces')->url('uploads/podcastImages/'.$this->artworkImage);
        return str_replace('digitalocean','cdn.digitalocean',$orginalAssetUrl);
    }
}
