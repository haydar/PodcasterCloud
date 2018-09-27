<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Purifier;

class Podcast extends Model
{
    use Sluggable;

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
