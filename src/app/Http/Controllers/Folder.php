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
}
