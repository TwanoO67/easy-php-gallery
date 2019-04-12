<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Tag extends Eloquent
{
    protected $guarded = [];

    public function photos()
    {
        return $this->belongsToMany(Photo::class,'tags');
    }
}
