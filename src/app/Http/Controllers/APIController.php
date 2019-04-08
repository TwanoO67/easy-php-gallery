<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process as Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Storage;

use App\Setting;


class APIController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function scan_start()
    {
       $process = new Process('cd /var/ww/html && touch mytralala && /usr/bin/php artisan import:scan');
       $process->start();
       return 'started';
    }

    public function scan_status(){
        return Setting::where(['type' => 'scan'])->first();
    }

    /**
     * Uploads a file to a specific folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function file_upload(Request $request)
    {
        $disk = Storage::disk("dockervolume");

        if (! $request->hasFile('files')) {
            return;
        }
        $files = $request->file('files');
        foreach ($files as $var => $file) {
            $destination = $request->get('directory') == "/" ? "/" : $request->get('directory') . "/";
            $path = $destination . $file->getClientOriginalName();
            $disk->put($path, file_get_contents($file));
        }

        return ["success" => true];
    }
}
