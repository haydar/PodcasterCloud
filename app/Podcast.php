<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
