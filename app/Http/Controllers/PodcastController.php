<?php

namespace App\Http\Controllers;

use App\Podcast;
use Illuminate\Http\Request;
use Auth;
use Image;
use Purifier;
use Storage;

class PodcastController extends Controller
{
    /**
     * Find Podcast in database
     *
     * @param string $slug
     * @return \app\Podcast
     */
    public function getPodcast($slug)
    {
        $podcast=Podcast::Where('slug',$slug)->first();

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
            $location=public_path('temp/'.$filename);
            Image::make($originalImage)->resize(400,300)->encode('jpg')->save($location);
            $imagePath=Storage::disk('doSpaces')->putFileAs('uploads/podcastImages',$originalImage, $filename,'public');
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
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $podcast=$this->getPodcast($slug);

        if ($podcast!=null)
        {
            if(Auth::id()==$podcast->user_id){
                return view('dashboard.pages.home')->withPodcast($podcast);
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
     * @param  \App\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function edit(Podcast $podcast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Podcast $podcast)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Podcast $podcast)
    {
        if ($podcast->user_id==Auth::id())
        {
            $podcast->delete();

            return response()->json(['message'=>'Podcast successfully deleted'],200);
        }
        else
        {
            abort(404);
        }
    }
}
