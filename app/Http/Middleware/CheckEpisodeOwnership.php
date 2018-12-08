<?php

namespace App\Http\Middleware;

use Closure;
use App\Episode;
use App\Podcast;

class CheckEpisodeOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $episodeSlug=$request->route('episode');

        $episode=Episode::where(['slug'=>$episodeSlug,
                                'podcast_id'=>$request->podcast_id])->first();

        if (empty($episode))
        {
            dd('Episode Mid.');
            return abort('404');
        }

        app()->instance(Episode::class, $episode);

        return $next($request);
    }
}
