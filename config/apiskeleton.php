<?php

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

    ],

    'folders' => [

        /*
         * When creating the models, the models will be placed directly in the app folder
         * without a specific namespace. If you are using your own folder, please provide
         * the name of the folder. The model will be placed inside this folder with the
         * given namespace.
         */

        'models' => null,

    ],

    /*
     * By default the resource collection will append `Collection` to the name. If you would
     * like to have the name of the collection pluralized set this option to true.
     */

    'use_pluralized_collections' => false,
];
