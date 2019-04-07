<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the result of install';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Check DB
        $this->comment("[ + ] Testing DB ");
        try {
            $models = \DB::collection('users')->raw(function($collection)
            {
                return $collection->find();
            });
           $this->info("MongoDB Ok ");
        } catch (\Exception $e) {
            dd($e);
            $this->error("Could not connect to the database.  Please check your configuration.");
        }
    }
}
