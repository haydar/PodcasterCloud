<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Episode;
use App\AudioFile;
use Storage;
use getID3;
use Illuminate\Http\File;

class CreateEpisode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $episodeArray;
    protected $audioFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($episode, AudioFile $audioFile)
    {
        $this->audioFile=$audioFile;
        $this->episodeArray=$episode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $audioFile=$this->audioFile;
        $episodeArray=$this->episodeArray;
        $episode=new Episode($episodeArray);

        $filename=$audioFile->file;
        $audioFileLocation=public_path('temp\\'.$audioFile->file);
        $episode->length=filesize($audioFileLocation);
        $audioMeta = new getID3();
        $audioMetaData=$audioMeta->analyze($audioFileLocation);
        $episode->duration= $audioMetaData['playtime_string'];
        
        if (file_exists($audioFileLocation))
        {
            Storage::disk('doSpaces')->putFileAs('uploads/episodes/episodeAudio', new File($audioFileLocation),$filename,'public');
            unlink($audioFileLocation);
            $episode->audio=$filename;

            $episode->save();
            $audioFile->delete();

            return response()->json(['message'=>'Episode successfully created.'],200);
        }
        else
        {
            return response()->json(['message'=>"Episode's audio file not found on the server"],404);
        }
    }
}
