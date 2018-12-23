<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $dispatchesEvents= [
        'created'=>Events\NewUser::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userverification()
    {
        return $this->hasOne(UserVerification::class);
    }

    public function podcast()
    {
        return $this->hasOne(Podcast::class);
    }

    public function getAvatarPath()
    {
        if ($this->avatar=='user.jpg'||$this->avatar=='')
        {
            return Storage::disk('doSpaces')->url('uploads/profileAvatars/user.jpg');
        }
        else
        {
            return Storage::disk('doSpaces')->url('uploads/profileAvatars/'.$this->avatar);
        }
    }

}
