<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'suresms' => [
        'user' => env('SURESMS_USER'),
        'password' => env('SURESMS_PASSWORD'),
        'phone_number' => env('SURESMS_PHONE_NUMBER'),
    ],

    'pushover' => [
        'app_token' => env('PUSHOVER_TOKEN'),
    ],

    'ewii' => [
        'email' => env('EWII_EMAIL'),
        'password' => env('EWII_PASSWORD'),
    ],

    'energioverblik' => [
        'refresh_token' => env('ENERGIOVERBLIK_REFRESH_TOKEN'),
    ],

    'smartme' => [
        'id' => env('SMART_ME_ID', 'test-id'),
        'username' => env('SMART_ME_USERNAME', 'test-user-name'),
        'paasword' => env('SMART_ME_PASSWORD', 'test-password'),
    ],

    'openai' => [
        'base_url' => env('OPENAI_API_URL', 'https://api.openai.com'),
        'key' => env('OPENAI_API_KEY'),
    ],
];
