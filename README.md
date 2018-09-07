# Package to create api skeletons with artisan

[![StyleCI](https://github.styleci.io/repos/147676542/shield)](https://styleci.io/repos/147676542)

This Laravel package creates an artisan command to generate an api skeleton.

``` bash
php artisan make:apiskeleton
```

Artisan will ask 2 questions to define in which namespace and which name your skeleton should use

``` bash
What is the namespace for the skeleton? [ApiSkeleton]
> Foo/Bar

What is the name for the skeleton? [ApiSkeleton}
> Hat
```

After the command the following files are created (may be different according to your config)

```
app 
└───Http
    └───Controllers
    │   └───Foo
    │       └───Bar
    │           |   HatController.php
    └───Requests
    │   └───Foo
    │       └───Bar
    │           |   StoreHatRequest.php
    │           |   UpdateHatRequest.php
    └───Resources
    │   └───Foo
    │       └───Bar
    │           |   Hat.php
    │           |   HatCollection.php
    Hat.php

database
└───factories
│   └───Foo
│       └───Bar
│           |   HatFactory.php
└───migrations
│   |   xxxx_xx_xx_xxxxxx_create_hats_table.php
└───seeds
    └───Foo
        └───Bar
            |   HatTestSeeder.php
 
tests
└───Feature
    └───Foo
        └───Bar
            |   HatDestroyTest.php 
            |   HatIndexTest.php 
            |   HatShowTest.php 
            |   HatStoreTest.php 
            |   HatUpdateTest.php    
```

## Installation and usage

This package requires PHP 7 and Laravel 5.6 or higher. Install the package by running the following command in your console;

``` bash
composer require sqits/laravel-api-skeleton
```

You can publish the config file with:

``` bash
php artisan vendor:publish --provider="Sqits\ApiSkeleton\ApiSkeletonServiceProvider" --tag="config"
```

This is the contents of the published config file:

``` php
return [

    'files' => [

        /*
         * Define if the model should be created when a new API skeleton is created.
         */

        'models' => true,

        /*
         * Define if the migration for the model should be created when a new API skeleton is created.
         * The models should be set to true for the migrations to be created.
         */

        'migrations' => true,

        /*
         * Define if the controller should be created when a new API skeleton is created.
         * When the model is created also, the model would be used automatically in the controller.
         */

        'controllers' => true,

        /*
         * Define if the requests should be created when a new API skeleton is created.
         * The following requests will be made StoreModelRequest and UpdateModelRequest
         */

        'requests' => true,

        /*
         * Define if the resources should be created when a new API skeleton is created.
         * The following resources will be made Model and ModelCollection.
         */

        'resources' => true,

        /*
         * Define if the tests should be created when a new API skeleton is created.
         * The following tests will be made ModelIndexText, ModelShowTest, ModelStoreTest,
         * ModelUpdateTest and ModelDestroyTest.
         *
         * Value should be true for creating the tests inside the Feature folder. set
         * the value to 'unit' to create the tests inside the Unit folder.
         */

        'tests' => true,

        /*
         * Define if the seeders should be created when a new API skeleton is created.
         */

        'seeders' => [

            /*
             * Define if the default seeder for the model should be created when a new
             * API skeleton is created.
             */

            'defaults' => false,

            /*
             * Define if the test seeder for the model should be created when a new
             * API skeleton is created.
             */

            'tests' => true,

        ],

        /*
         * Define if the factories should be created when a new API skeleton is created.
         * The following resources will be made Model and ModelCollection.
         */

        'factories' => true,
        
        /*
         * Define if the services should be created when a new API skeleton is created.
         * You should define a folder in the config where the service should be located.
         *
         * If this option is set to true, artisan will ask the user to confirm the generation
         * of the service to make it optional per skeleton. If you want to skip the question
         * your should add --service to the make:apiskeleton command.
         */

        'services' => true,
        
        /*
         * Define if the repositories should be created when a new API skeleton is created.
         * You should define a folder in the config where the repository should be located.
         * 
         * If this option is set to true, artisan will ask the user to confirm the generation
         * of the factory to make it optional per skeleton. If you want to skip the question
         * your should add --repository to the make:apiskeleton command.
         */

        'repositories' => true,

    ],

    'folders' => [

        /*
         * When creating the models, the models will be placed directly in the app folder
         * without a specific namespace. If you are using your own folder, please provide
         * the name of the folder. The model will be placed inside this folder with the
         * given namespace.
         */

        'models' => null,
        
        /*
         * When creating the services, the services will be placed inside the given
         * folder which will be placed inside the app folder of your application.
         */

        'services' => 'Services',
        
        /*
         * When creating the repositories, the repositories will be placed inside the given
         * folder which will be placed inside the app folder of your application.
         */
        
        'repositories' => 'Repositories',

    ],


    /*
     * By default the resource collection will append `Collection` to the name. If you would
     * like to have the name of the collection pluralized set this option to true.
     */

    'use_pluralized_collections' => false,
];
```

You can publish the stub files with:

``` bash
php artisan vendor:publish --provider="Sqits\ApiSkeleton\ApiSkeletonServiceProvider" --tag="stubs"
```

The stub files are placed inside your resources folder and will contain:

``` bash
resources 
└───stubs
    └───apiskeleton
        |   repository.stub
```


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security-related issues, please [email](mailto:info@sqits.nl) to info@sqits.nl instead of using the issue tracker.

## Credits

- [Sqits](https://github.com/sqits)
- [Ruud Schaaphuizen](https://github.com/rschaaphuizen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.