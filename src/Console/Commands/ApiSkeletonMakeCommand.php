<?php

namespace Sqits\ApiSkeleton\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class ApiSkeletonMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:apiskeleton';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an API skeleton with the given namespace.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The namespace for the skeleton.
     *
     * @var string
     */
    protected $namespace = 'ApiSkeleton';

    /**
     * The name of the model for the skeleton.
     *
     * @var string
     */
    protected $modelName = 'ApiSkeleton';

    /**
     * The model, if the model is created in the skeleton.
     *
     * @var string
     */
    protected $model = null;

    /**
     * The controller, if the controller is created in the skeleton.
     *
     * @var string
     */
    protected $controller = null;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->askNamespace();
        $this->askName();

        $this->makeModel();
        $this->makeController();
        $this->makeRequests();
        $this->makeResources();
        $this->makeTests();
        $this->makeSeeders();
        $this->makeFactory();
    }

    /**
     * Asks which namespace should be used.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * return void
     */
    private function askNamespace()
    {
        $this->namespace = $this->ask('What is the namespace for the skeleton?', 'ApiSkeleton');

        if (substr($this->namespace, -1) === '/') {
            $this->namespace = substr($this->namespace, -1);
        }
    }

    /**
     * Asks which name should be used.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * return void
     */
    private function askName()
    {
        $this->modelName = $this->ask('What is the name for the skeleton?', 'ApiSkeleton');
    }

    /**
     * Creates the model if the model should be created due the config.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * return void
     */
    private function makeModel()
    {
        if (! config('apiskeleton.files.models')) {
            return;
        }

        $this->model = $this->modelName;

        if (config('apiskeleton.folders.models') !== null) {
            $this->model = sprintf(
                '%s/%s/%s',
                config('apiskeleton.folders.models'),
                $this->namespace,
                $this->modelName
            );
        }

        Artisan::call('make:model', [
            'name' => $this->model,
            '--migration' => config('apiskeleton.files.migrations'),
        ]);

        $this->info("The model {$this->model} has been created.");

        if (config('apiskeleton.files.migrations')) {
            $this->info('The migration for the model has been created');
        }
    }

    /**
     * Creates the controller if the controller should be created due the config.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * return void
     */
    private function makeController()
    {
        if (! config('apiskeleton.files.controllers')) {
            return;
        }

        $this->controller = sprintf(
            '%s/%sController',
            $this->namespace,
            $this->modelName
        );

        Artisan::call('make:controller', [
            'name' => $this->controller,
            '--api' => true,
            '--model' => config('apiskeleton.files.models') ? $this->model : false,
        ]);

        $this->info("The controller {$this->controller} has been created.");
    }

    /**
     * Creates the requests if the requests should be created due the config.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * return void
     */
    private function makeRequests()
    {
        if (! config('apiskeleton.files.requests')) {
            return;
        }

        $storeRequestName = sprintf(
            '%s/Store%sRequest',
            $this->namespace,
            $this->modelName
        );

        Artisan::call('make:request', [
            'name' => $storeRequestName,
        ]);

        $updateRequestName = sprintf(
            '%s/Update%sRequest',
            $this->namespace,
            $this->modelName
        );

        Artisan::call('make:request', [
            'name' => $updateRequestName,
        ]);

        $this->info("The requests {$storeRequestName} and {$updateRequestName} has been created.");
    }

    /**
     * Creates the resources if the resources should be created due the config.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * return void
     */
    private function makeResources()
    {
        if (! config('apiskeleton.files.resources')) {
            return;
        }

        $resourceName = sprintf(
            '%s/%s',
            $this->namespace,
            $this->modelName
        );

        Artisan::call('make:resource', [
            'name' => $resourceName,
        ]);

        if (config('apiskeleton.use_pluralized_collections')) {
            $modelCollectionName = str_plural($this->modelName);
        } else {
            $modelCollectionName = $this->modelName.'Collection';
        }

        $resourceCollectionName = sprintf(
            '%s/%s',
            $this->namespace,
            $modelCollectionName
        );

        Artisan::call('make:resource', [
            'name' => $resourceCollectionName,
            '--collection' => config('apiskeleton.use_pluralized_collections'),
        ]);

        $this->info("The resources {$resourceName} and {$resourceCollectionName} has been created.");
    }

    /**
     * Creates the tests if the tests should be created due the config.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * @return void
     */
    private function makeTests()
    {
        if (! config('apiskeleton.files.tests')) {
            return;
        }

        $actionNames = [
            'Index',
            'Show',
            'Store',
            'Update',
            'Destroy',
        ];

        $createdFiles = [];

        foreach ($actionNames as $actionName) {
            $testName = sprintf(
                '%s/%s%sTest',
                $this->namespace,
                $this->modelName,
                $actionName
            );

            Artisan::call('make:test', [
                'name' => $testName,
                '--unit' => config('apiskeleton.files.tests') === 'unit',
            ]);

            $createdFiles[] = $testName;
        }

        $this->info('The tests '.implode(', ', $createdFiles).' has been created.');
    }

    /**
     * Creates the seeders if the seeders should be created due the config.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * @return void
     */
    private function makeSeeders()
    {
        if (config('apiskeleton.files.seeders.defaults')) {
            $this->makeSeeder();
        }

        if (config('apiskeleton.files.seeders.tests')) {
            $this->makeSeeder('Test');
        }
    }

    /**
     * Creates the seeder and moves the seeder to the right subdirectory due the
     * given namespace for the skeleton.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * @param null $prepend
     *
     * @return void
     */
    private function makeSeeder($prepend = null)
    {
        $seederDirectoryName = sprintf(
            '%s/seeds/%s',
            $this->laravel->databasePath(),
            $this->namespace
        );

        $seederFileName = sprintf(
            '%s%sSeeder',
            $this->modelName,
            $prepend
        );

        $seederFinalLocation = sprintf(
            '%s/%s.php',
            $seederDirectoryName,
            $seederFileName
        );

        Artisan::call('make:seeder', [
            'name' => $seederFileName,
        ]);

        if (! $this->files->isDirectory($seederDirectoryName)) {
            $this->files->makeDirectory($seederDirectoryName, 0755, true);
        }

        $this->files->move(
            $this->laravel->databasePath().'/seeds/'.$seederFileName.'.php',
            $seederFinalLocation
        );

        $this->info("The seeder {$seederFileName} has been created.");
    }

    /**
     * Creates the factory and moves the factory to the right subdirectory due the
     * given namespace for the skeleton. The model is also inserted into the factory
     * if the model is created in the skeleton.
     *
     * @author Ruud Schaaphuizen (r.schaaphuizen@sqits.nl)
     * @since 1.0.0
     *
     * @return void
     */
    private function makeFactory()
    {
        if (! config('apiskeleton.files.factories')) {
            return;
        }

        $factoryDirectoryName = sprintf(
            '%s/factories/%s',
            $this->laravel->databasePath(),
            $this->namespace
        );

        $factoryFileName = sprintf(
            '%sFactory',
            $this->modelName
        );

        $factoryFinalLocation = sprintf(
            '%s/%s.php',
            $factoryDirectoryName,
            $factoryFileName
        );

        Artisan::call('make:factory', [
            'name' => $factoryFileName,
            '--model' => config('apiskeleton.files.models') ? $this->model : false,
        ]);

        if (! $this->files->isDirectory($factoryDirectoryName)) {
            $this->files->makeDirectory($factoryDirectoryName, 0755, true);
        }

        $this->files->move(
            $this->laravel->databasePath().'/factories/'.$factoryFileName.'.php',
            $factoryFinalLocation
        );

        $this->info("The factory {$factoryFileName} has been created.");
    }
}
