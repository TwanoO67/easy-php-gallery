<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use Redirect;
use Auth;
use Storage;
use Response;
use App\Models\Album;

class AdminController extends Controller
{

  public function deleteUser($id){

    $user = User::findOrFail($id);
    $user->albums()->delete();
    $user->delete();

    return Redirect::to('admin');

  }

  public function setAdmin($id,$bool){

    $user = User::findOrFail($id);
    $user->is_admin = $bool;
    $user->save();

    return Redirect::to('admin');

  }

  public function autocomplete(){

      $term = Input::get('term');

      //Recuperation des dossiers niveau 1
      $disk = Storage::disk("dockervolume");

      $all = $disk->allDirectories();

      $matchingFiles = preg_grep("/$term/i", $all);


      //$directories = ['/' => '/'];
      //preparation des dossiers
      foreach ($matchingFiles as $num => $dir) {
        //if( strpos(strtolower($dir), $term) ){
          $directories[] = [
            'id' => $dir,
            'value' => $dir
          ];
        //}
          //$directories[] = ['id'=>'/','value'=>'/']; //basename($dir),
      }

      return Response::json($directories);
    }


    public function list(){

      $albums = Album::all();

      $users = User::all();

      $disks = array_keys(config('filesystems.disks'));

      $access = [
        "RW" => "Lecture/Ecriture",
        "R" => "Lecture seule",
      ];

      //Recuperation des themes
      $disk = Storage::disk("themes");
      $themes = [];
      //preparation des dossiers
      foreach ($disk->directories() as $num => $dir) {
        $themes[$dir] = $dir; //basename($dir),
      }

      //Recuperation des dossiers
      $disk = Storage::disk("dockervolume");
      $directories = ['/' => '/'];
      //preparation des dossiers
      foreach ($disk->allDirectories() as $num => $dir) {
        $directories[$dir] = $dir; //basename($dir),
      }



      return view("themes/paper/admin",compact('albums','users','disks','access','themes','directories'));

    }

}
