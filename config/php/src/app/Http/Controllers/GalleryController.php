<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Models\User;
use App\Models\Album;
use App\Services\ThumborService;


class GalleryController extends Controller
{
    private $thumbor;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ThumborService $thumbor)
    {
        $this->thumbor = $thumbor;
        $this->middleware('auth');
    }

    private function human_filesize($bytes, $decimals = 2) {
        $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    private function getDirLink($dossier){
      return url("gallery",['dossier' => base64_encode($dossier)]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($directory = '/')
    {
        $disk = Storage::disk("dockervolume");//$folder->disk);
        $directories = [];
        $files = [];
        $parent = null;
        if($directory !== '/'){
            $directory = base64_decode($directory);

            //si on est dans un sous dossier, on calcule le dossier parent
            $parents = explode('/',$directory);
            array_pop($parents);
            $parent = $this->getDirLink( implode('/',$parents) );
        }

        $backlink = false;

        //reglages
        $format_date = "Y/m/d G:i:s";
        $title = "Dossier ".$directory;
        $default_fondecran = "/images/back.jpg";

        //preparation des dossiers
        foreach ($disk->directories($directory) as $dir) {
            $directories[] = [
                "filename" => $dir,
                "basename" => basename($dir),
                "mimetype" => "folder",
                "dirlink" => $this->getDirLink('/'.$dir),
            ];
        }

        //recuperation des images
        $first = $default_fondecran;
        foreach ($disk->files($directory) as $file) {

            //exclusion des fichiers cachés (ex: .DStore, miniature de Mac OsX )
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
                    "small" => $this->thumbor->getImgLink($file,"640x360"),
                    "big" => $this->thumbor->getImgLink($file,"1920x1080"),
                    "full" => $this->thumbor->getImgLink($file,"0x0")
                ]
            ];



            if($first == $default_fondecran) $first = $this->thumbor->getImgLink($file,"1920x700");

            $files[] = $curfile;
        }

        $child_directories = $disk->allDirectories();

        $albums = Album::all();

        //theme par defaut
        $theme = "themes/paper/gallery";
        /*if($folder->theme){
            $template = $folder->theme."/gallery";
            $store = Storage::disk("themes");
            if($store->exists($template.'.blade.php')){
                $theme = "themes/".$template;
            }
        }*/


        return view($theme,compact('title','directories','files','first','backlink','directory','parent', 'child_directories', 'albums'));
    }
}
