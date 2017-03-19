<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Redirect;
use App\Folder;
use Auth;

class FolderController extends Controller
{

    public function store(Request $request)
    {

        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'user_id'   => 'required|numeric',
            'access_level' => 'required'
        );
        $validator = $this->validate($request, $rules);

        $dossier = str_replace('//', '/', '/'.Input::get('directory'));

        // store
        $new_folder = new Folder;
        $new_folder->user_id = Input::get('user_id');
        $new_folder->directory = $dossier;
        $new_folder->access_level = Input::get('access_level');
        $new_folder->theme = Input::get('theme');
        $new_folder->save();

        return Redirect::to('admin');

    }

    public function delete($id)
    {

        $folder = Folder::find($id);
        $folder->delete();

        return Redirect::to('admin');

    }

}
