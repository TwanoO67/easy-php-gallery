<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Album extends Eloquent
{
    protected $guarded = [];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}