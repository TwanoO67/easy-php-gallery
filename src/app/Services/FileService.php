<?php

namespace App\Service;

use Storage;
use App\Photo;
use App\Setting;

class FileService
{
    private static function human_filesize($bytes, $decimals = 2) {
        $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    private static function import_file_in_dir($directory){
        $disk = Storage::disk("dockervolume");
        $files = $disk->files($directory);
        $format_date = "Y/m/d G:i:s";

        $setting = Setting::first(['type' => 'scan']);
        $setting->todo += count($files);
        $setting->save(); 
        echo "Fichiers découvert:".$setting->todo;

        //recuperation des images
        foreach ( $files as $file) {

            //exclusion des miniature de osX
            $basename = basename($file);
            if( strpos($basename, '.') === 0 ) continue;

            //on test le mimetype, et exclue ce qui n'est pas une image
            $type = $disk->mimeType($file);
            if( strpos( $type, "image") !== 0 ) continue;

            //on ajoute seulement si inexistant
            $found = Photo::where(["filename" => $file])->first();
            if(!$found){
                $cur_file = Photo::create([
                    "filename" => $directory.$file,
                    "basename" => $basename,
                    "mtime" => date($format_date, $disk->lastModified($file)),
                    "mimetype" => $type,
                    "size" => self::human_filesize($disk->size($file)),
                    
                ]);
            }

            $setting->done += 1;
            $setting->save();
            echo "Fichiers fait:".$setting->done;

        }
        //recuperation des sous dossiers
        foreach ($disk->directories($directory) as $dir) {
            self::import_file_in_dir($dir);
        }
    }

    public static function scan()
    {
        $directory = '/';

        Setting::updateOrCreate([
            'type' => 'scan'],
            [
                'todo' => 0,
                'done' => 0
            ]
        );

        //preparation des dossiers
        self::import_file_in_dir($directory);

    }
}
