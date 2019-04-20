<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use App\User;

class StorageController extends Controller
{
    private function human_filesize($bytes, $decimals = 2) {
        $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    //renvoi le lien vers thumbor de l'image
    private function getImgLink($file,$resolution=""){
      return "/convert/unsafe/".$resolution.'/'.$file;
    }

    private function getDirLink($dossier){
      return url("gallery",['dossier' => base64_encode($dossier)]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'new_directory' => 'required_without:destination_directory',
            'destination_directory' =>'required_without:new_directory',
            'files' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()
            ], 422);
        }


        $disk = Storage::disk("dockervolume");//$folder->disk);

        if(isset($data['new_directory']) ){
            $destination = $disk->makeDirectory($data['new_directory']);
        }
        else{
            $destination = $data['destination_directory'];
        }
        

        if($data['files'] && count($data['files']) > 0){
            foreach($data['files'] as $file){
                $disk->move($file, $destination.DIRECTORY_SEPARATOR.basename($file));
            }
        }

        return response()->json($destination, 201);
    }
}
