<?php

namespace App\Http\Controllers;

use App\AudioFile;
use App\Episode;
use App\Jobs\CreateEpisode;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Auth;
use Image;
use Storage;
use getID3;


class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $podcastSlug
     * @return \Illuminate\Http\Response
     */
    public function index($podcastSlug)
    {
        $podcast=app(PodcastController::class)->getPodcast($podcastSlug);

        //If there is no podcast with given slug, abort
        if ($podcast!=null)
        {
            $episodes=Episode::where('podcast_id',$podcast->id)->get();
            return view('dashboard.pages.episodeIndex')->withPodcast($podcast)
                                                        ->withEpisodes($episodes);
        }
        else
        {
            return abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $podcastSlug
     * @return \Illuminate\Http\Response
     */
    public function create($podcastSlug)
    {
        $podcast=app(PodcastController::class)->getPodcast($podcastSlug);

        //If there is no podcast with given slug, abort
        if ($podcast!=null)
        {
            return view('dashboard.pages.episodeCreate')->withPodcast($podcast);
        }
        else
        {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $podcastSlug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadEpisodeAudioFile(Request $request, $podcastSlug)
    {
        $podcast=app(PodcastController::class)->getPodcast($podcastSlug);

        if ($podcast!=null)
        {
            $this->validate($request, array(
                'audio'=>'required|mimes:mpga,m4a,mp4,m4r',
            ));

            if ( $request->hasFile('audio') )
            {
                $audioFile=$request->file('audio');
                $filename=time().'-'.str_replace(' ','',$audioFile->getClientOriginalName());
                $location=public_path('temp\\'.$filename);

                move_uploaded_file($audioFile,$location);

                $audio=new AudioFile;

                $audio->podcast_id=$podcast->id;
                $audio->file=$filename;

                $audio->save();

                return response()->json(['message'=>'file successfully uploaded',
                                        'audioFileId'=>$audio->id],200);
            }
        }
        else
        {
            return abort(404);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $podcastSlug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $podcastSlug)
    {
        $podcast=app(PodcastController::class)->getPodcast($podcastSlug);

        if ($podcast!=null)
        {
            $this->validate($request,array(
                'title'=>'required|string|max:255',
                'subtitle'=>'nullable|string|max:255',
                'description'=>'required|string',
                'image'=>'image|dimensions:min_width=400,min_height=400|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'audioFile'=>'required|numeric',
                'explicit'=>'required|boolean'
            ));

            $episode=new Episode;

            $episode->title=$request->title;

            if($request->has('subtitle'))
                $episode->subtitle=$request->subtitle;
            else
                $episode->subtitle=$podcast->subtitle;

            $episode->description=$request->description;
            $episode->explicit=$request->explicit;
            $episode->podcast_id=$podcast->id;

            //if there is custom episode image, upload episode's image to DigitalOcean Spaces
            if($request->hasFile('image'))
            {
                $originalImage=$request->file('image');
                $filename=str_replace(' ','',$request->title).'-'.time().'.'.$originalImage->getClientOriginalExtension();
                $location=public_path('temp\\'.$filename);
                Image::make($originalImage)->resize(400,400)->encode('jpg')->save($location);
                Storage::disk('doSpaces')->putFileAs('uploads/episodes/episodeImage', new File($location), $filename,'public');
                unlink($location);

                $episode->image=$filename;
            }

            $audioFile=AudioFile::where(['id'=>$request->audioFile,
                                        'podcast_id'=>$podcast->id])->first();

            if($audioFile!=null)
            {
                CreateEpisode::dispatch($episode->toArray(),$audioFile);
                return response()->json(['message'=>'Episode successfully sent.'],200);
            }
            else
            {
                return response()->json(['message'=>'Given Audio File Id is invalid for '.$podcast->name.' podcast.'],422);
            }

        }
        else
        {
            return abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $episodeSlug
     * @param  string $podcastSlug
     * @return \Illuminate\Http\Response
     */
    public function show($podcastSlug, $episodeSlug)
    {
        $podcast=app(PodcastController::class)->getPodcast($podcastSlug);
        //If there is no podcast with given slug, abort
        if ($podcast!=null)
        {
            //Check is this episode relative with this episode
            $episode=Episode::where(['slug'=>$episodeSlug,
                                    'podcast_id'=>$podcast->id])->first();
            if($episode!=null)
            {
                return view('dashboard.pages.episodeShow')->withPodcast($podcast)
                                                            ->withEpisode($episode);
            }
            else
            {
                return abort(404);
            }
        }
        else
        {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function edit(Episode $episode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $podcastSlug, $episodeSlug)
    {
        $this->validate($request,[
            'title'=>'required|string|max:255',
            'subtitle'=>'nullable|string|max:255',
            'description'=>'required|string',
            'image'=>'image|dimensions:min_width=400,min_height=400|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'explicit'=>'required|boolean'
        ]);

        $podcast=app(PodcastController::class)->getPodcast($podcastSlug);

        if ($podcast!=null)
        {
           $episode=Episode::where('slug',$episodeSlug)->first();

           if ($episode!=null&&$episode->podcast_id==$podcast->id)
           {
                $episode->title=$request->title;

                if($request->has('subtitle'))
                    $episode->subtitle=$request->subtitle;
                else
                    $episode->subtitle=$podcast->subtitle;

                $episode->description=$request->description;
                $episode->explicit=$request->explicit;

                //if there is custom episode image, upload episode's image to DigitalOcean Spaces
                if($request->hasFile('image'))
                {
                    $originalImage=$request->file('image');
                    $filename=str_replace(' ','',$request->title).'-'.time().'.'.$originalImage->getClientOriginalExtension();
                    $location=public_path('temp\\'.$filename);
                    Image::make($originalImage)->resize(400,400)->encode('jpg')->save($location);
                    Storage::disk('doSpaces')->putFileAs('uploads/episodes/episodeImage', new File($location), $filename,'public');
                    unlink($location);

                    $episode->image=$filename;
                }

                $episode->save();
                return response()->json(['message'=>'Episode successfully updated!'],200);
           }
           else
           {
                abort(404);
           }

        }
        else
        {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Episode $episode)
    {
        //
    }
}
