<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($directory = '/')
    {


        //theme par defaut
        $theme = "themes/paper/map";
        /*if($folder->theme){
            $template = $folder->theme."/gallery";
            $store = Storage::disk("themes");
            if($store->exists($template.'.blade.php')){
                $theme = "themes/".$template;
            }
        }*/
        $title = "Carte";


        return view($theme,compact('title'));
    }

}
