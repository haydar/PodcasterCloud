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
            $orginalEpisodeImage=Storage::disk('doSpaces')->url('uploads/episodes/episodeImage/'.$this->image);
            return str_replace('digitalocean','cdn.digitalocean',$orginalEpisodeImage);
        }
        else
        {
            return $this->podcast->getArtworkImagePath();
        }
    }

    public function getAudioFilePath()
    {
        $orginalEpisodeAudio=Storage::disk('doSpaces')->url('uploads/episodes/episodeAudio/'.$this->audio);
        return str_replace('digitalocean','cdn.digitalocean',$orginalEpisodeAudio);
    }

    public function deleteAssets()
    {
        //Delete episode image
        if(Storage::disk('doSpaces')->exists('uploads/episodes/episodeImage/'.$this->image))
        {
            Storage::disk('doSpaces')->delete('uploads/episodes/episodeImage/'.$this->image);
        }

        //Delete episode audio
        if(Storage::disk('doSpaces')->exists('uploads/episodes/episodeAudio/'.$this->audio))
        {
            Storage::disk('doSpaces')->delete('uploads/episodes/episodeAudio/'.$this->audio);
        }
    }
}
