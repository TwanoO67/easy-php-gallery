<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use Auth;
use Response;
use App\Folder;

class Gallery extends Controller
{

  private function human_filesize($bytes, $decimals = 2) {
      $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
      $factor = floor((strlen($bytes) - 1) / 3);
      return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
  }

  //renvoi le lien vers thumbor de l'image
  private function getImgLink($file,$resolution=""){
    return "/convert/unsafe/".$resolution.'/'.urlencode($file);
  }

  private function getDirLink($id,$dossier){
    return url("gallery",['id' => $id, 'dossier' => base64_encode($dossier)]);
  }

  public function index($id,$dossier=""){

    $folder = Folder::findOrFail($id);
    $cur_user = Auth::user();

    //ici pour une raison inconnu le user_id dans le folder est une string
    if( !$cur_user || $folder->user_id+0 !== $cur_user->id ){
      dd("Accés refusé");
    }

    $directory = $folder->directory;
    $backlink = false;
    if($dossier !== ""){
      $dossier = base64_decode($dossier);
      $directory .= $dossier;

      //on retire un dossier au nom
      $dirs = explode('/', $dossier);
      array_pop($dirs);
      $dir = implode('/', $dirs);

      $backlink = $this->getDirLink($id,$dir);
    }
    $disk = Storage::disk("dockervolume");//$folder->disk);
    $directories = [];
    $files = [];

    //reglage
    $format_date = "Y/m/d G:i:s";
    $title = "Gallerie ".$directory;
    $default_fondecran = "/images/back.jpg";

    //preparation des dossiers
    foreach ($disk->directories($directory) as $dir) {
      $directories[] = [
        "filename" => $dir,
        "basename" => basename($dir),
        "mimetype" => "folder",
        "dirlink" => $this->getDirLink($id,$dir),
      ];
    }

    //recuperation des images
    $first = $default_fondecran;
    foreach ($disk->files($directory) as $file) {

      //on test le mimetype, et exclue ce qui n'est pas une image
      $type = $disk->mimeType($file);
      if( strpos( $type, "image") !== 0 ) continue;

      $curfile = [
        "filename" => $file,
        "mtime" => date($format_date, $disk->lastModified($file)),
        "mimetype" => $type,
        "size" => $this->human_filesize($disk->size($file)),
        "img_links" => [
          "small" => $this->getImgLink($file,"640x360"),
          "big" => $this->getImgLink($file,"1920x1080")
        ]
      ];

      if($first == $default_fondecran) $first = $this->getImgLink($file,"1920x700");

      $files[] = $curfile;
    }


    return view('nanogallery',compact('title','directories','files','first','backlink'));

  }

  /*//retourne le fichier brute de l'image
  public function image($id){
    $file = Storage::disk('dockervolume')->get($id);
    $type = Storage::disk('dockervolume')->mimeType($id);

    $response = Response::make($file, 200);
    $response->header("Content-Type",$type);

    return $response;
  }*/


}
