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
       $process = new Process('cd /var/ww/html && touch mytralala && /usr/bin/php artisan import:scan');
       $process->start();
       return 'started';
    }

    public function scan_status(){
        return Setting::where(['type' => 'scan'])->first();
    }
}
