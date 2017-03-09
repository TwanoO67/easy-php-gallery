<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder as FolderModel;

class Folder extends Controller
{
    public function list(){

      $folders = FolderModel::all();

      return view('folder',compact('folders'));

    }

    public function create(array $data)
    {
        return FolderModel::create([
            'user_id' => $data['user_id'],
            'disk' => $data['disk'],
            'directory' => $data['directory'],
            'access_level' => $data['access_level'],
        ]);
    }
}
