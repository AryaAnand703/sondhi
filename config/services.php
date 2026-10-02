<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN', env('POSTMARK_API_KEY')),
        'key' => env('POSTMARK_API_KEY', env('POSTMARK_TOKEN')),
    ],

    'resend' => [
        'key' => env('RESEND_KEY', env('RESEND_API_KEY')),
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

    'payment' => [
        'gateway_key' => env('PAYMENT_GATEWAY_KEY', env('RAZORPAY_KEY_SECRET')),
    ],

    'razorpay' => [
        'key' => env('RAZORPAY_KEY_ID'),
        'key_id' => env('RAZORPAY_KEY_ID'),
        'secret' => env('RAZORPAY_KEY_SECRET'),
        'key_secret' => env('RAZORPAY_KEY_SECRET'),
    ],

    'twilio' => [
        'sid' => env('TWILIO_SID', env('TWILIO_ACCOUNT_SID')),
        'token' => env('TWILIO_AUTH_TOKEN', env('TWILIO_TOKEN')),
        'from' => env('TWILIO_NUMBER', env('TWILIO_FROM', env('TWILIO_PHONE_NUMBER'))),
        'verify_sid' => env('TWILIO_VERIFY_SID'),
    ],

];
