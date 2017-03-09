<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
  protected $fillable = [
      'user_id', 'disk', 'acces_level',
  ];
}
