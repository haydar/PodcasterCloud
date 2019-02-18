<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Episode;
use App\Podcast;
use App\AudioFile;
use Storage;
use getID3;
use Carbon\Carbon;
use Illuminate\Http\File;

class ImportEpisodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected $podcast;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $podcast)
    {
        $this->url=$url;
        $this->podcast=$podcast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $url=$this->url;
        $podcast=$this->podcast;

        $xml=\simplexml_load_file($url);

        for ($i=0; $i < count($xml->channel->item); $i++)
        {
            \set_time_limit(0);
            
            $item=new Episode;

            $item->podcast_id=$podcast['id'];
            $item->title=$xml->channel->item[$i]->title;
            $item->subtitle=$podcast['subtitle'];

            $date=new Carbon($xml->channel->item[$i]->pubDate);
            $item->created_at=$date;

            $item->description=$xml->channel->item[$i]->description;

            $audioFile=$xml->channel->item[$i]->enclosure['url'];

            file_put_contents(public_path('temp/')."episode.mp3", fopen($audioFile, 'r'));

            $location=public_path('temp/')."episode.mp3";

            $newFilename=time().'-'.str_replace(' ','',"episode.mp3");
            \rename(public_path('temp/')."episode.mp3", public_path('temp/').$newFilename);
            $audioFileLocation=public_path('temp/').$newFilename;

            $audioMeta = new getID3();
            $audioMetaData=$audioMeta->analyze($audioFileLocation);
            $item->duration= $audioMetaData['playtime_string'];

            Storage::disk('doSpaces')->putFileAs('uploads/episodes/episodeAudio', new File($audioFileLocation),$newFilename,'public');

            unlink($audioFileLocation);

            $item->audio=$newFilename;
            $item->length=$xml->channel->item[$i]->enclosure['length'];

            if (!empty($xml->channel->item[$i]->image))
            {
                file_put_contents(public_path('temp/')."episode.jpg", fopen($xml->channel->item[$i]->image, 'r'));
                $newFilename=time().'-'.str_replace(' ','',"episode.jpg");
                \rename(public_path('temp/')."episode.jpg", public_path('temp/').$newFilename);
                $imageFileLocation=public_path('temp/').$newFilename;

                Storage::disk('doSpaces')->putFileAs('uploads/episodes/episodeImage', new File($imageFileLocation),$newFilename,'public');
                $item->image=$newFilename;

                unlink($imageFileLocation);
            }

            $item->save();
        }
    }
}
