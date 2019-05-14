<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Photo;

class TagController extends Controller
{

    //renvoi le lien vers thumbor de l'image
    private function getImgLink($file,$resolution=""){
        $file = str_replace('/mydata/','',$file);
        return "/convert/unsafe/".$resolution.'/'.$file;
      }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($directory = '/')
    {
        $tags = Tag::all();

        //theme par defaut
        $theme = "themes/paper/tags";
        /*if($folder->theme){
            $template = $folder->theme."/gallery";
            $store = Storage::disk("themes");
            if($store->exists($template.'.blade.php')){
                $theme = "themes/".$template;
            }
        }*/
        $title = "Tags";


        return view($theme,compact('tags','title'));
    }

    public function tag($id)
    {
        $tag = Tag::find($id);
        $title = "Tags ".$tag->name;

        $photos = Photo::where([ "tags.name" => $tag->name ])->get();

        foreach($photos as $photo){
            $file = $photo->path;

            //dd($file);
            $photo->img_links = [
                "small" => $this->getImgLink($file,"640x360"),
                "big" => $this->getImgLink($file,"1920x1080"),
                "full" => $this->getImgLink($file,"0x0")
            ];
        }

        //theme par defaut
        $theme = "themes/paper/tag";
        /*if($folder->theme){
            $template = $folder->theme."/gallery";
            $store = Storage::disk("themes");
            if($store->exists($template.'.blade.php')){
                $theme = "themes/".$template;
            }
        }*/

        return view($theme,compact('tag','title','photos'));
    }
}
