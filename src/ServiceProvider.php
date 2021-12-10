<?php

namespace stuartcusackie\sglide;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{   

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sglide.php' => config_path('sglide.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../assets/images/' => public_path('/vendor/sglide/images/'),
        ], 'assets');
    }
}
