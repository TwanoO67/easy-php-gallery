<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\User;

class GalleryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function human_filesize($bytes, $decimals = 2) {
        $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
  
    //renvoi le lien vers thumbor de l'image
    private function getImgLink($file,$resolution=""){
      return "/convert/unsafe/".$resolution.'/'.$file;
    }
  
    private function getDirLink($id,$dossier){
        return 'todo';
      return url("gallery",['id' => $id, 'dossier' => base64_encode($dossier)]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $disk = Storage::disk("dockervolume");//$folder->disk);
        $directories = [];
        $files = [];
        $directory = '/';
        $id = 'todo';
        $backlink = false;

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
            
            //exclusion des miniature de osX
            $basename = basename($file);
            if( strpos($basename, '.') === 0 ) continue;

            

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
                    "big" => $this->getImgLink($file,"1920x1080"),
                    "full" => $this->getImgLink($file,"0x0")
                ]
            ];

            

            if($first == $default_fondecran) $first = $this->getImgLink($file,"1920x700");

            $files[] = $curfile;
        }

        //theme par defaut
        $theme = "themes/paper/gallery";
        /*if($folder->theme){
            $template = $folder->theme."/gallery";
            $store = Storage::disk("themes");
            if($store->exists($template.'.blade.php')){
                $theme = "themes/".$template;
            }
        }*/


        return view($theme,compact('title','directories','files','first','backlink'));
    }
}
