<?php

namespace App\Http\Controllers;

use App\AudioFile;
use App\Episode;
use App\Podcast;
use App\Jobs\CreateEpisode;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Auth;
use Image;
use Storage;
use getID3;


class EpisodeController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkPodcastOwnership');
        $this->middleware('checkEpisodeOwnership')->except(['index', 'store', 'create', 'uploadEpisodeAudioFile']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Podcast  $givenPodcast
     * @return \Illuminate\Http\Response
     */
    public function index(Podcast $givenPodcast)
    {
        $episodes=Episode::where('podcast_id',$givenPodcast->id)->get();
         return view('dashboard.pages.episodeIndex')->withPodcast($givenPodcast)
                                                    ->withEpisodes($episodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Podcast  $givenPodcast
     * @return \Illuminate\Http\Response
     */
    public function create(Podcast $givenPodcast)
    {
        return view('dashboard.pages.episodeCreate')->withPodcast($givenPodcast);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Podcast  $givenPodcast
     * @return \Illuminate\Http\Response
     */
    public function uploadEpisodeAudioFile(Request $request, Podcast $givenPodcast)
    {
        $this->validate($request, array(
            'audio'=>'required|mimes:mpga,m4a,mp4,m4r',
        ));

        $audioFile=$request->file('audio');
        $filename=time().'-'.str_replace(' ','',$audioFile->getClientOriginalName());
        $location=public_path('temp\\'.$filename);

        move_uploaded_file($audioFile,$location);

        $audio=new AudioFile;

        $audio->podcast_id=$givenPodcast->id;
        $audio->file=$filename;

        $audio->save();

        return response()->json(['message'=>'file successfully uploaded',
                                'audioFileId'=>$audio->id],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Podcast  $givenPodcast
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Podcast $givenPodcast)
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
            $episode->subtitle=$givenPodcast->subtitle;

        $episode->description=$request->description;
        $episode->explicit=$request->explicit;
        $episode->podcast_id=$givenPodcast->id;

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
                                    'podcast_id'=>$givenPodcast->id])->first();

        if($audioFile!=null)
        {
            CreateEpisode::dispatch($episode->toArray(),$audioFile);
            return response()->json(['message'=>'Episode successfully sent.'],200);
        }
        else
        {
            return response()->json(['message'=>'Given Audio File Id is invalid for '.$givenPodcast->name.' podcast.'],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Podcast  $givenPodcast
     * @param  \App\Episode  $givenEpisode
     * @return \Illuminate\Http\Response
     */
    public function show(Podcast $givenPodcast, Episode $givenEpisode)
    {
        return view('dashboard.pages.episodeShow')->withPodcast($givenPodcast)
                                                    ->withEpisode($givenEpisode);
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
     * @param  \App\Podcast  $givenPodcast
     * @param  \App\Episode  $givenEpisode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Podcast $givenPodcast, Episode $givenEpisode)
    {
        $this->validate($request,[
            'title'=>'required|string|max:255',
            'subtitle'=>'nullable|string|max:255',
            'description'=>'required|string',
            'image'=>'image|dimensions:min_width=400,min_height=400|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'explicit'=>'required|boolean'
        ]);

        $givenEpisode->title=$request->title;

        if($request->has('subtitle'))
            $givenEpisode->subtitle=$request->subtitle;
        else
            $givenEpisode->subtitle=$givenPodcast->subtitle;

        $givenEpisode->description=$request->description;
        $givenEpisode->explicit=$request->explicit;

        //if there is custom episode image, upload episode's image to DigitalOcean Spaces
        if($request->hasFile('image'))
        {
            $originalImage=$request->file('image');
            $filename=str_replace(' ','',$request->title).'-'.time().'.'.$originalImage->getClientOriginalExtension();
            $location=public_path('temp\\'.$filename);
            Image::make($originalImage)->resize(400,400)->encode('jpg')->save($location);
            Storage::disk('doSpaces')->putFileAs('uploads/episodes/episodeImage', new File($location), $filename,'public');
            unlink($location);

            $givenEpisode->image=$filename;
        }

        $givenEpisode->save();
        return response()->json(['message'=>'Episode successfully updated!'],200);

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
