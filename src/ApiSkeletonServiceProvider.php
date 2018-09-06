<?php

namespace Sqits\ApiSkeleton;

use Illuminate\Support\ServiceProvider;
use Sqits\ApiSkeleton\Console\Commands\ApiSkeletonMakeCommand;

class ApiSkeletonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/apiskeleton.php' => config_path('apiskeleton.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ApiSkeletonMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/apiskeleton.php', 'apiskeleton'
        );
    }
}
