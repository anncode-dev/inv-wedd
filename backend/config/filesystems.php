<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        
        'product' => [
            'driver' => 'local',
            'root' => storage_path('app/public/product'),
            'url' => env('APP_URL').'/storage/product',
            'visibility' => 'public',
            'throw' => false,
        ],
        
        'tinymce' => [
            'driver' => 'local',
            'root' => storage_path('app/public/tinymce'),
            'url' => env('APP_URL').'/storage/tinymce',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'image' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/uploads/image'),
            'url'        => env('APP_URL') . '/storage/uploads/image',
        ],

        'video' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/uploads/video'),
            'url'        => env('APP_URL') . '/storage/uploads/video',
        ],

        'audio' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/uploads/audio'),
            'url'        => env('APP_URL') . '/storage/uploads/audio',
        ],

        'file' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/uploads/file'),
            'url'        => env('APP_URL') . '/storage/uploads/file',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
