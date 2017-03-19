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
    private function verifyAdminOrDie(){
      $cur_user = Auth::user();
      if(!$cur_user->is_admin){
        dd("Accés refusé");
      }
    }

    public function store(Request $request)
    {
        $this->verifyAdminOrDie();

        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'user_id'   => 'required|numeric',
            'directory' => 'required',
            'access_level' => 'required'
        );
        $validator = $this->validate($request, $rules);

        // store
        $nerd = new Folder;
        $nerd->user_id = Input::get('user_id');
        $nerd->directory = Input::get('directory');
        $nerd->access_level = Input::get('access_level');
        $nerd->save();

        return Redirect::to('admin');

    }

    public function delete($id)
    {
        $this->verifyAdminOrDie();

        $folder = Folder::find($id);
        $folder->delete();

        return Redirect::to('admin');

    }

}
