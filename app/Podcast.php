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
        $this->hasOne(Episode::class);
    }

    public function getArtworkImagePath()
    {
        return Storage::disk('doSpaces')->url('uploads/podcastImages/'.$this->artworkImage);
    }
}
