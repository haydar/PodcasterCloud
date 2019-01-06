<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Episode;
use Storage;

class DeletePodcastAssets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $episodesArray;

    public $tries = 5;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($episodes)
    {
        $this->episodesArray=$episodes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $episodes=$this->episodesArray;

        foreach ($episodes as $episode)
        {
            $givenEpisode=new Episode($episode);
            $givenEpisode->deleteAssets();
        }
    }
}
