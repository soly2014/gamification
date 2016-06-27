<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
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
        'model' => Learncloud\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    
    'facebook' => [
    'client_id' => '1058284937567093',
    'client_secret' => '35ddec17273ebdf59a2102d287ef319d',
    'redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],


    'twitter' => [
    'client_id' => env('Fjk1r0zpXhwn8DSM7i9BUlwcv'),
    'client_secret' => env('57EmMRH28IWMPeA70fbbQaPoCIXEssPP5gpRIW3cASty3vsF6R'),
    'redirect' => env('http://joinlearncloud.com/auth/twitter/callback'),
    ],

/*http://stackoverflow.com/questions/32773364/socialite-auth-how-do-i-include-more-than-one-redirect-uri-for-each-service
*/

];
