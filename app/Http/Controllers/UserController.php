<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('user.show', Auth::id());
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::id()==$id)
        {
            return view('dashboard.pages.userShow');
        }
        else
        {
            //if user want access another user profile, abort
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

        $user=User::find($id);
        
        if(Hash::check($request->currentPassword, $user->password))
        {
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=bcrypt($request->newPassword);
            $user->save();

            return response()->json([
                'status'=>true,
                'message'=>'User successfully updated',
            ]);
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
    public function postUpdateAvatar(Request $request, $id)
    {
        $this->validate($request, array(
            'avatar'=>'required|image|dimensions:min_width=400,min_height=400|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ));

        $user=User::find($id);

        if ($request->hasFile('avatar')) {
            #
        }
    }
}
