<?php

namespace App\Http\Middleware;

use Closure;
use App\Podcast;
use Auth;

class CheckPodcastOwnership
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
        $podcastSlug=$request->route('podcast');

        $podcast=Podcast::where(['slug'=>$podcastSlug,
                                'user_id'=>Auth::id()])->first();

        if (empty($podcast))
        {
            return response('Unauthorized.', 401);
        }

        app()->instance('App\Podcast', $podcast);

        return $next($request);
    }
}
