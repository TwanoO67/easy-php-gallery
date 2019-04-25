<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Photo extends Eloquent
{
    protected $guarded = [];

    public function tags()
    {
        return $this->embedsMany(Tag::class);
    }
}
