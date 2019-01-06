<?php

namespace App\Http\Controllers;

use App\Podcast;
use Illuminate\Http\Request;
use Auth;
use Image;
use Purifier;
use Storage;
use Illuminate\Http\File;
use App\Episode;

class PodcastController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkPodcastOwnership')->except(['index', 'store', 'create']);
    }

    /**
     * Find Podcast in database
     *
     * @param string $slug
     * @return \app\Podcast
     */
    public function getPodcast($slug)
    {
        $podcast=Podcast::Where(['slug'=>$slug,
                                'user_id'=>Auth::id()])->first();

        return $podcast;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $podcasts=Podcast::Where('user_id', Auth::id())->get();

        return view('dashboard.pages.managePodcasts')->withPodcasts($podcasts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.createPodcast');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name'=>'required|string|max:255',
            'subtitle'=>'required|string|max:255',
            'description'=>'required|string|max:600',
            'language'=>'required|string|max:20',
            'category'=>'required|string|max:255',
            'artworkImage'=>'required|image|dimensions:min_width=400,min_height=400|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'itunesEmail'=>'nullable|email|max:255',
            'authorName'=>'nullable|string|max:255',
            'itunesSummary'=>'nullable|string|max:255',
            'website'=>'nullable|string|max:50|url',
        ));

        if($request->name=="create")
        {
            return redirect()->route('podcast.create')->withErrors("Podcast Name cannot be 'create'.");
        }

        $podcast=new Podcast;

        $podcast->user_id=Auth::id();
        $podcast->name=Purifier::clean($request->name);
        $podcast->subtitle=Purifier::clean($request->subtitle);
        $podcast->description=Purifier::clean($request->description);
        $podcast->language=$request->language;
        $podcast->category=$request->category;

        if($request->hasFile('artworkImage'))
        {
            $originalImage=$request->file('artworkImage');
            $filename=str_replace(' ','',$request->name).'-'.time().'.'.$originalImage->getClientOriginalExtension();
            $location=public_path('temp\\'.$filename);
            Image::make($originalImage)->resize(400,300)->encode('jpg')->save($location);
            Storage::disk('doSpaces')->putFileAs('uploads/podcastImages', new File($location), $filename,'public');
            unlink($location);
        }

        $podcast->website=Purifier::clean($request->website);
        $podcast->artworkImage= $filename;
        $podcast->itunesEmail= Purifier::clean($request->itunesEmail);
        $podcast->authorName=Purifier::clean($request->authorName);
        $podcast->itunesSummary=Purifier::clean($request->itunesSummary);

        $podcast->save();

        return redirect()->route('podcast.show',$podcast->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Podcast  $givenPodcast
     * @return \Illuminate\Http\Response
     */
    public function show(Podcast $givenPodcast)
    {
        return view('dashboard.pages.showPodcast')->withPodcast($givenPodcast);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function edit(Podcast $givenPodcast)
    {
        return view('dashboard.pages.podcastEdit')->withPodcast($givenPodcast);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Podcast $givenPodcast)
    {
        $this->validate($request, array(
            'name'=>'required|string|max:255',
            'subtitle'=>'required|string|max:255',
            'description'=>'required|string|max:600',
            'language'=>'required|string|max:20',
            'category'=>'required|string|max:255',
            'itunesEmail'=>'nullable|email|max:255',
            'authorName'=>'nullable|string|max:255',
            'itunesSummary'=>'nullable|string|max:255',
            'website'=>'nullable|string|max:50|url'
        ));

        if ($request->hasFile('artworkImage'))
        {
            $this->validate($request,['artworkImage'=>'required|image|dimensions:min_width=400,min_height=400|mimes:jpeg,png,jpg,gif,svg|max:2048']);

            $originalImage=$request->file('artworkImage');
            $filename=str_replace(' ','',$request->name).'-'.time().'.'.$originalImage->getClientOriginalExtension();
            $location=public_path('temp\\'.$filename);
            Image::make($originalImage)->resize(400,300)->encode('jpg')->save($location);
            Storage::disk('doSpaces')->putFileAs('uploads/podcastImages', new File($location), $filename,'public');
            unlink($location);

            //Delete old podcast image
            Storage::disk('doSpaces')->delete('uploads/podcastImages/'.$givenPodcast->artworkImage);

            //Write new podcast artwork image to database
            $givenPodcast->artworkImage=$filename;

        }

        $givenPodcast->name=$request->name;
        $givenPodcast->subtitle=$request->subtitle;
        $givenPodcast->description=$request->description;
        $givenPodcast->language=$request->language;
        $givenPodcast->category=$request->category;
        $givenPodcast->itunesEmail=$request->itunesEmail;
        $givenPodcast->authorName=$request->authorName;
        $givenPodcast->itunesSummary=$request->itunesSummary;
        $givenPodcast->website=$request->website;

        $givenPodcast->save();

        $filePath=Storage::disk('doSpaces')->url('uploads/podcastImages/'.$givenPodcast->artworkImage);
        return response()->json(['message'=>'Podcast Updated!',
                                'podcastName'=>$givenPodcast->name,
                                'imagePath'=>$filePath], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Podcast $givenPodcast)
    {
        //Delete all episodes and their assets.
        $episodes=Episode::where('podcast_id',$givenPodcast->id)->get();
        foreach ($episodes as $episode)
        {
            $episode->deleteAssets();
            $episode->delete();
        }

        //Delete Podcast image
        if(Storage::disk('doSpaces')->exists('uploads/podcastImages/'.$givenPodcast->artworkImage))
        {
            Storage::disk('doSpaces')->delete('uploads/podcastImages'.$givenPodcast->artworkImage);
        }

        $givenPodcast->delete();

        return response()->json(['message'=>'Podcast successfully deleted'],200);
    }
}
