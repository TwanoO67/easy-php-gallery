<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process as Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
       $process = new Process('cd /var/ww/html && touch mytralala && /usr/bin/php artisan import:scan && echo toto &');


       $process->run();

       // executes after the command finishes
       if (!$process->isSuccessful()) {
          return $process->getOutput();
       }
       return $process->getOutput();

       $process->start();
       $set = Setting::where('type','scan')->first();
       $set->todo = 0;
       $set->done = 0;
       $set->save();
       return 'started';
    }

    public function scan_status(){
        return Setting::where(['type' => 'scan'])->first();
    }
}
