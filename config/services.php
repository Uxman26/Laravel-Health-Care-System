<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '87464212873-hhq6i0nghbebsh9lebodfddirrh90die.apps.googleusercontent.com',
        'client_secret' => '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', 
        //'redirect' => 'https://digiaccess24.com/digilancers/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '342980568042996',
        'client_secret' => 'd37acf8c8b3c6f031dd4f4b1764cf00a',
        //'redirect' => 'https://digiaccess24.com/digilancers/auth/facebook/callback',
      ], 

    'pusher' => [
        'pusher_app_id' => '1466958', 
        'pusher_app_key' => '8d6c6fbc431c83be86b4',         
        'pusher_app_secret' => 'f270bb4bf7c46c8719c0', 
        'pusher_app_cluster' => 'ap2', 
    ],

];
