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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'dolibarr' => [
        'base_url' => env('DOLIBARR_URL'),
        'htaccess_url' => env('DOLIBARR_URL_HTACCESS'),
        'username' => env('DOLIBARR_USERNAME'),
        'password' => env('DOLIBARR_PWD'),
        'api_key' => env('DOLIBARR_APIKEY')
    ],
    'ispconfig' => [
        'servers' => [
            'mail_server' => [
                'name' => 'ISP Config Mail',
                'soap_location' => env('ISPCONFIG_MAIL_SOAP_LOCATION'),
                'soap_uri' => env('ISPCONFIG_MAIL_SOAP_URI'),
                'username' => env('ISPCONFIG_MAIL_USERNAME'),
                'password' => env('ISPCONFIG_MAIL_PASSWORD'),
            ],
            'web_server' => [
                'name' => 'ISP Config Web',
                'soap_location' => env('ISPCONFIG_WEB_SOAP_LOCATION'),
                'soap_uri' => env('ISPCONFIG_WEB_SOAP_URI'),
                'username' => env('ISPCONFIG_WEB_USERNAME'),
                'password' => env('ISPCONFIG_WEB_PASSWORD'),
            ],
            'test_server' => [
                'name' => 'ISP Config TEST',
                'soap_location' => env('ISPCONFIG_TEST_SOAP_LOCATION'),
                'soap_uri' => env('ISPCONFIG_TEST_SOAP_URI'),
                'username' => env('ISPCONFIG_TEST_USERNAME'),
                'password' => env('ISPCONFIG_TEST_PASSWORD'),
            ],
        ],
        'cache_ttl' => env('ISPCONFIG_CACHE_TTL', 300), // 5 minutes
    ],
    'nextcloud' => [
        'url' => env('NEXTCLOUD_URL'),
        'user' => env('NEXTCLOUD_USERNAME'),
        'password' => env('NEXTCLOUD_PASSWORD')
    ],
];
