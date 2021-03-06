<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Addon Types
    |--------------------------------------------------------------------------
    |
    | When loading addons the system will look for SLUG-TYPE addons to load.
    |
    */

    'types' => [
        'field_type',
        'extension',
        'module',
        'plugin',
        'theme'
    ],

    /*
    |--------------------------------------------------------------------------
    | Configured Addon Paths
    |--------------------------------------------------------------------------
    |
    | These manually defined addon paths can be helpful
    | when you need to push an addon path into load
    | that is shipped IN another addon.
    |
    */

    'paths' => [
        //addons/shared/example-module/addons/anomaly/fancy-field_type'
    ],

    /*
    |--------------------------------------------------------------------------
    | Eager Loaded Addons
    |--------------------------------------------------------------------------
    |
    | Eager loaded addons are registered first and can be defined
    | here by specifying their relative path to the project root.
    |
    */

    'eager' => [
        //'core/anomaly/redirects-module'
    ],

    /*
    |--------------------------------------------------------------------------
    | Deferred Addons
    |--------------------------------------------------------------------------
    |
    | Deferred loaded addons are registered last and can be defined
    | here by specifying their relative path to the project root.
    |
    */

    'deferred' => [
        //'core/anomaly/pages-module'
    ]
];
