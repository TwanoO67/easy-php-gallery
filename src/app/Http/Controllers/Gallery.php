<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use Response;

class Gallery extends Controller
{

  private function human_filesize($bytes, $decimals = 2) {
      $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
      $factor = floor((strlen($bytes) - 1) / 3);
      return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
  }

  private function getImgLink($file,$resolution=""){

    $url = route('image_raw', ['id' => $file]);
    return $url;
    //return "/convert/unsafe/".$resolution.'/'.urlencode($url);
  }

  public function index(){
    $directory = '/';
    $directories = [];
    $files = [];

    //reglage
    $disk = Storage::disk('dockervolume');
    $format_date = "Y/m/d G:i:s";
    $title = "Gallerie";
    $default_fondecran = "images/back.jpg";

    //preparation des dossiers
    foreach ($disk->directories($directory) as $dir) {
      $directories[] = [
        "filename" => $dir,
        "mtime" => "",
        "mimetype" => "folder",
        "dirlink" => "",
        "size" => ""
      ];
    }

    //recuperation des images
    $first = $default_fondecran;
    foreach ($disk->files($directory) as $file) {

      //on test le mimetype, et exclue ce qui n'est pas une image
      $type = $disk->mimeType($file);
      if( strpos( $type, "image") === false ) continue;

      $curfile = [
        "filename" => $file,
        "mtime" => date($format_date, $disk->lastModified($file)),
        "mimetype" => $type,
        "dirlink" => "",
        "size" => $this->human_filesize($disk->size($file)),
        "img_links" => [
          "small" => $this->getImgLink($file,"640x360"),
          "big" => $this->getImgLink($file,"1920x1080")
        ]
      ];

      if($first == $default_fondecran) $first = $this->getImgLink($file,"1920x700");

      $files[] = $curfile;
    }

    return view('album',compact('title','directories','files','first'));

  }

  //retourne le fichier brute de l'image
  public function image($id){
    $file = Storage::disk('dockervolume')->get($id);
    $type = Storage::disk('dockervolume')->mimeType($id);

    $response = Response::make($file, 200);
    $response->header("Content-Type",$type);

    return $response;
  }


}
