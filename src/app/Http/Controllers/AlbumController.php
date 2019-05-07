<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Album;
use App\Models\Photo;
use App\Services\FileService;
use Auth;
use Redirect;

class AlbumController extends Controller
{

    private $fileservice;
    public function __construct(FileService $file)
    {
        $this->fileservice = $file;
    }

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

    public function fullPath($path){
        return $this->fileservice->fullPath('/',$path);
    }

    public function album_files(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'album_id' => 'required',
            'folders' =>'array',
            'files' => 'array',
        ]);

        $album = Album::findOrFail($data['album_id']);

        $photos = Photo::whereIn('path', array_map(array($this, 'fullPath'),$data['files']) )->get();
    
        foreach($photos as $photo){
            $album->photos()->save($photo);
        }

        if(!isset($album->folders)){
            $album->folders = [];
        }
        $album->folders = array_merge($album->folders,$data['folders']);

        $album->save();
        return response()->json($album, 200);

    }

    public function album($id)
    {
        $album = Album::find($id);
        $title = "Albums ".$album->name;

        foreach($album->photos as $file){
            $file->img_links = [
                "small" => $this->getImgLink($file['path'],"640x360"),
                "big" => $this->getImgLink($file['path'],"1920x1080"),
                "full" => $this->getImgLink($file['path'],"0x0")
            ];
        }

        //theme par defaut
        $theme = "themes/paper/album";

        return view($theme,compact('album','title','photos'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'access_level' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()
            ], 422);
        }

        $dossier = str_replace('//', '/', '/'.$data['directory']);

        // store
        $new_album = new Album();
        $new_album->user_id = Auth::user()->id;
        $new_album->upload_directory = $dossier;
        $new_album->access_level = $data['access_level'];
        $new_album->name = $data['name'];
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
