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

    'mpesa' => [
        'access_token_endpoint' => env('ACCESS_TOKEN_ENDPOINT'),
        'register_url_endpoint' => env('REGISTER_URL_ENDPOINT'),
        'simulate_url_endpoint' => env('SIMULATE_URL_ENDPOINT'),
        'mpesa_b2c_endpoint' => env('MPESA_B2C_ENDPOINT'),
        'mpesa_short_code' => env('MPESA_SHORT_CODE'),
        'consumer_key' => env('CONSUMER_KEY'),
        'consumer_secret' => env('CONSUMER_SECRET'),
        'mpesa_passkey' => env('MPESA_PASSKEY'),
    ],

    'sms' => [
        'send_sms_endpoint' => env('SEND_SMS_ENDPOINT'),
        'sms_account_balance_endpoint' => env('SMS_ACCOUNT_BALANCE_ENDPOINT'),
        'sms_api_key' => env('SMS_API_KEY'),
        'short_code' => env('SHORT_CODE'),
        'partner_id' => env('PARTNER_ID'),
    ],

];
