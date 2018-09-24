<?php

namespace App\Http\Controllers;

use App\Podcast;
use Illuminate\Http\Request;
use Auth;
use Image;

class PodcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.managePodcasts');
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
            'name'=>'required|max:255',
            'subtitle'=>'required|max:255',
            'description'=>'required|max:600',
            'language'=>'required|max:20',
            'category'=>'required|max:255',
            'artworkImage'=>'required|image|dimensions:min_width=400,min_height=400|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'itunesEmail'=>'nullable|email|max:255',
            'authorName'=>'nullable|max:255|alpha',
            'itunesSummary'=>'nullable|max:255',
        ));

        if($request->name=="create")
        {
            return redirect()->route('podcast.create')->withErrors("Podcast Name cannot be 'create'.");
        }

        $podcast=new Podcast;

        $podcast->user_id=Auth::id();
        $podcast->name=$request->name;
        $podcast->subtitle=$request->subtitle;
        $podcast->description=$request->description;
        $podcast->language=$request->language;
        $podcast->category=$request->category;

        if($request->hasFile('artworkImage'))
        {
            $image=$request->file('artworkImage');
            $filename=$request->name.'-'.time().'.'.$image->getClientOriginalExtension();
            $location=public_path('images/'.$filename);
            Image::make($image)->resize(400,400)->save($location);
        }

        $podcast->artworkImage=$filename;
        $podcast->itunesEmail=$request->itunesEmail;
        $podcast->authorName=$request->authorName;
        $podcast->itunesSummary=$request->itunesSummary;

        $podcast->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function show(Podcast $podcast)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Podcast $podcast)
    {
        //
    }
}
