<?php

namespace Sqits\ApiSkeleton\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:apiskeleton-repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository with the given namespace.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if (File::exists(resource_path('stubs/apiskeleton/repository.stub'))){
            return resource_path('stubs/apiskeleton/repository.stub');
        }

        return __DIR__.'/../../../resources/stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\'.config('apiskeleton.folders.repositories');
    }
}
