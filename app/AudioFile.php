<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioFile extends Model
{
    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
