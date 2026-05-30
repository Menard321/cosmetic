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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    'nextsms' => [
        'key' => env('NEXTSMS_API_KEY', '96adf70e9dce08ac'),
        'secret' => env('NEXTSMS_SECRET_KEY', 'NjMzYTMwY2ZjODY1Mzg4NTA1ZjlmOTg0ZDhkM2QyZTdlNWI4NzAyYzgwZDZlY2M1M2ZmNTYzODYxZDZhNGM4OA=='),
        'sender_id' => env('NEXTSMS_SENDER_ID', 'NEXTSMS'),
        'base_url' => env('NEXTSMS_BASE_URL', 'https://messaging-service.co.tz/api/sms/v1'),
    ],

];
