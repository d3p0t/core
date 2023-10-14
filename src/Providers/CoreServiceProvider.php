<?php

namespace D3p0t\Core\Providers;

use D3p0t\Core\Traits\PublishesMigrations;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

    use PublishesMigrations;

    public function boot() {        
        $this->registerMigrations(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__.'/../config/activitylog.php' => config_path('activitylog.php'),
        ], 'activitylog');
    }

    public function register() {
        $this->mergeConfigFrom(
            __DIR__.'/../config/activitylog.php',
            'activitylog'
        );
    }

}