<?php

namespace Sqits\ApiSkeleton\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\GeneratorCommand;

class ServiceMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:apiskeleton-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a service with the given namespace.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if (File::exists(resource_path('stubs/apiskeleton/service.stub'))) {
            return resource_path('stubs/apiskeleton/service.stub');
        }

        return __DIR__.'/../../../resources/stubs/service.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\'.config('apiskeleton.folders.services');
    }
}
