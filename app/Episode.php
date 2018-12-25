<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Storage;

class Episode extends Model
{
    use Sluggable;

    protected $fillable = [
        'title','subtitle','description','explicit','podcast_id','file','image'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }

    public function audio_file()
    {
        return $this->hasOne(AudioFile::class);
    }

    public function getImagePath()
    {
        if(isset($this->image))
        {
            return Storage::disk('doSpaces')->url('uploads/episodes/episodeImage/'.$this->image);
        }
        else
        {
            return $this->podcast->getArtworkImagePath();
        }
    }
}
