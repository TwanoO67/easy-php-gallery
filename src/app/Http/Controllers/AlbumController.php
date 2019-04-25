<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Album;
use App\Models\Photo;
use Redirect;

class AlbumController extends Controller
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
        $albums = Album::all();

        //theme par defaut
        $theme = "themes/paper/albums";
        /*if($album->theme){
            $template = $album->theme."/gallery";
            $store = Storage::disk("themes");
            if($store->exists($template.'.blade.php')){
                $theme = "themes/".$template;
            }
        }*/
        $title = "Albums";


        return view($theme,compact('albums','title'));
    }

    public function album($id)
    {
        $album = Album::find($id);
        $title = "Albums ".$album->name;

        $photos = $album->photos;

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
        $theme = "themes/paper/album";
        /*if($album->theme){
            $template = $album->theme."/gallery";
            $store = Storage::disk("themes");
            if($store->exists($template.'.blade.php')){
                $theme = "themes/".$template;
            }
        }*/

        return view($theme,compact('album','title','photos'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'user_id'   => 'required',
            'access_level' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()
            ], 422);
        }

        $dossier = str_replace('//', '/', '/'.$data['directory']);

        // store
        $new_album = new Album();
        $new_album->user_id = $data['user_id'];
        $new_album->directory = $dossier;
        $new_album->access_level = $data['access_level'];
        $new_album->theme = $data['theme'];
        $new_album->save();

        return Redirect::to('admin');

    }

    public function delete($id)
    {

        $album = Album::find($id);
        $album->delete();

        return Redirect::to('admin');

    }
}
