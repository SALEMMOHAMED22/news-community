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
        'scheme' => 'https',
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
        'client_id' =>'29425221035-qsh9r1qoh98ph91fi1s62b3eis3j7pf5.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' =>'http://localhost:8000/auth/google/callback',
    ],
    
    'facebook' => [
        'client_id' =>'552489571164540',
        'client_secret' =>'f8fa7b4dc073ffcc3b1276693e562677',
        'redirect' =>'http://localhost:8000/auth/facebook/callback',
    ],

];
