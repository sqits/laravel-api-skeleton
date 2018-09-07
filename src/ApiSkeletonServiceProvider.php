<?php

namespace Sqits\ApiSkeleton;

use Illuminate\Support\ServiceProvider;
use Sqits\ApiSkeleton\Console\Commands\ApiSkeletonMakeCommand;
use Sqits\ApiSkeleton\Console\Commands\RepositoryMakeCommand;
use Sqits\ApiSkeleton\Console\Commands\ServiceMakeCommand;

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
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/stubs' => resource_path('stubs/apiskeleton'),
        ], 'stubs');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ApiSkeletonMakeCommand::class,
                ServiceMakeCommand::class,
                RepositoryMakeCommand::class,
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
