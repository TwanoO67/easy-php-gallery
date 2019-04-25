<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use Illuminate\Support\Facades\Artisan;

use App\Models\Setting;


class APIController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function scan_start()
    {
        \Log::info("scan start");
        Artisan::call('import:scan');

        $set = Setting::where('type','scan')->first();
        $set->todo = 0;
        $set->done = 0;
        $set->save();


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
