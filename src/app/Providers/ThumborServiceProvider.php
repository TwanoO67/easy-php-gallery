<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Thumbor\Url\BuilderFactory;
use Config;

class ThumborServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BuilderFactory::class, function ($app) {
            return BuilderFactory::construct(Config::get('app.url')."/convert", Config::get('app.thumbor_key'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
