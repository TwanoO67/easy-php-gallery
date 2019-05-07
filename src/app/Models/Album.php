<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Album extends Eloquent
{
    protected $guarded = [];

    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
