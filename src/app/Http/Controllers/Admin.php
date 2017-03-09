<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Redirect;
use Auth;
use App\Folder;

class Admin extends Controller
{
    public function list(){

      $cur_user = Auth::user();

      if(!$cur_user->is_admin){
        dd("Accés refusé");
      }

      $folders = Folder::all();

      $users = [];
      $full_users = User::all();
      foreach ($full_users as $user) {
        $users[ $user->id ] = $user->email;
      }

      $disks = array_keys(config('filesystems.disks'));

      $access = [
        "RW" => "Lecture/Ecriture",
        "R" => "Lecture seule",
      ];

      return view('admin',compact('folders','users','full_users','disks','access'));

    }

}
