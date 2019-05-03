<?php

namespace App\Services;

use Storage;
use App\Models\Photo;
use App\Models\Setting;
use App\Models\Tag;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FileService
{
    private static function human_filesize($bytes, $decimals = 2) {
        $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    private static function getTags($str){
        $tags = [];
        $str = str_replace("\n", "", $str);
        $str = str_replace("'", '"', $str);
        $str = str_replace("className", '"className"', $str);
        $str = str_replace("probability", '"probability"', $str);
        $retour = json_decode($str,true);
        if($retour !== null){
            foreach($retour as $tag){
                //Ne prend pas en compte la probability pour le moment
                //$tags[$tag['className']] = $tag['probability'];
                $found = Tag::where('name', $tag['className'])->first();
                if(!$found){
                    $ntag = new Tag();
                    $ntag->name = $tag['className'];
                    $ntag->save();
                    $found = $ntag;
                }
                $tags[] = $found;
            }
        }
        return $tags;
    }

    private static function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }

    public static function fullPath($directory,$file){
        $path = '/mydata'.$directory;
        if( ! self::endsWith($path, '/') ){
            $path .= '/';
        }
        $path .= $file;
        $path = str_replace('//','/',$path);
        return $path;
    }

    private static function import_files_from_dir($directory){
        $disk = Storage::disk("dockervolume");
        $files = $disk->files($directory);
        $format_date = "Y/m/d G:i:s";

        $setting = Setting::where('type','scan')->first();
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

                //Systeme de tag
                $process = new Process(['node','/var/www/tensorflow/local/index.js', self::fullPath($directory,$file)]);
                $process->run();

                // executes after the command finishes
                if (!$process->isSuccessful()) {
                   $tags = [];
                }
                else{
                    $tags = self::getTags($process->getOutput());
                }

                $cur_file = Photo::create([
                    "path" => self::fullPath($directory,$file),
                    "basename" => $basename,
                    "mtime" => date($format_date, $disk->lastModified($file)),
                    "mimetype" => $type,
                    "size" => self::human_filesize($disk->size($file)),
                ]);
                foreach($tags as $tag){
                    $cur_file->tags()->associate($tag);
                }
                $cur_file->save();

            }

            $setting->done += 1;
            $setting->save();
            echo "Fichiers fait:".$setting->done;

        }
        //recuperation des sous dossiers
        foreach ($disk->directories($directory) as $dir) {
            self::import_files_from_dir($dir);
        }
    }

    public static function scan()
    {
        $directory = '/';

        Setting::updateOrCreate(
          [
            'type' => 'scan'
          ],
          [
            'todo' => 0,
            'done' => 0
          ]
        );

        //preparation des dossiers
        self::import_files_from_dir($directory);

    }
}
