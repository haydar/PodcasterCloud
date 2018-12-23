<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
use Session;
use Storage;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$slug)
    {
        if(Auth::id()==$id)
        {
            $podcast=app(PodcastController::class)->getPodcast($slug);

            //If there is no podcast with given slug, abort
            if ($podcast!=null)
                return view('dashboard.pages.userShow')->withPodcast($podcast);
            else
                return abort(404);
        }
        else
        {
            //If user want access another user profile, abort
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|exists:users',
            'currentPassword' => 'required|string|min:6',
            'newPassword' => 'required|string|min:6|confirmed',
        ]);

        //if user want edit another user profile, abort
        if(Auth::id()==$id)
        {
            $user=User::find($id);

            if(Hash::check($request->currentPassword, $user->password))
            {
                $user->name=$request->name;
                $user->email=$request->email;
                $user->password=bcrypt($request->newPassword);
                $user->save();

                return response()->json(['message'=>'User successfully updated'],200);
            }
            else{
                return response()->json(['message'=>"Your old password looks wrong. Please re-type current password"],401);
            }
        }
        else{
            return abort(404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update avatar and delete old avatar image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateAvatar(Request $request, $id)
    {
        $this->validate($request, array(
            'avatar'=>'required|image|dimensions:min_width=124,min_height=124|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ));

        $user=User::find($id);

        if ($request->hasFile('avatar'))
        {
            $image=$request->file('avatar');
            $filename=str_replace(' ','',$request->name).time().'.'.$image->getClientOriginalExtension();
            $location=public_path('temp/'.$filename);
            Image::make($image)->resize(124,124)->encode('jpg')->save($location);
            Storage::disk('doSpaces')->putFileAs('uploads/profileAvatars',$image, $filename,'public');
            unlink($location);

            $avatarPath=Storage::disk('doSpaces')->url('uploads/profileAvatars/'.$filename);

            //Delete old avatar if user's avatar isn't default avatar
            if ($user->avatar!='user.jpg')
            {
                if(Storage::disk('doSpaces')->exists('uploads/profileAvatars/'.$user->avatar))
                {
                    Storage::disk('doSpaces')->delete('uploads/profileAvatars/'.$user->avatar);
                }
            }

            $user->avatar=$filename;
            $user->save();

            return response()->json(['message'=>'Avatar successfully updated','avatarPath'=> $avatarPath]);
        }
    }
}
