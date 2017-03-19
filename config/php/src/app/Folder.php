<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
  protected $fillable = [
      'user_id', 'directory', 'access_level', 'theme'
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }
}
