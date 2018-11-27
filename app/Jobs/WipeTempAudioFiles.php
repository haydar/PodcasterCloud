<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\AudioFile;
use Carbon\Carbon;

class WipeTempAudioFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $audioFiles=AudioFile::where('created_at','<',Carbon::now()->subSecond()->toDateTimeString())->get();
        foreach ($audioFiles as $audioFile) {
            $filePath=public_path("temp\\".$audioFile->file);
            if(file_exists($filePath))
            {
                unlink($filePath);
            }
            $audioFile->delete();
        }
    }
}
