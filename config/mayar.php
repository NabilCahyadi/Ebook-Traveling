<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mayar.id API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Mayar.id payment gateway integration.
    | Get your API key from: https://mayar.id/dashboard
    |
    */

    'api_key' => env('MAYAR_API_KEY'),

    'environment' => env('MAYAR_ENVIRONMENT', 'sandbox'), // sandbox or production

    'base_url' => env('MAYAR_ENVIRONMENT', 'sandbox') === 'production'
        ? 'https://api.mayar.id'
        : 'https://api.mayar.id/sandbox',

    'callback_url' => env('MAYAR_CALLBACK_URL'),

    'return_url' => env('MAYAR_RETURN_URL'),

    /*
    |--------------------------------------------------------------------------
    | Payment Link Configuration
    |--------------------------------------------------------------------------
    */

    'link_expiry_hours' => 24, // Payment link expires in 24 hours

    'auto_activate_subscription' => true, // Auto activate subscription on payment success

    /*
    |--------------------------------------------------------------------------
    | Supported Payment Methods
    |--------------------------------------------------------------------------
    */

    'payment_methods' => [
        'va_bca',
        'va_bni',
        'va_bri',
        'va_mandiri',
        'va_permata',
        'qris',
        'gopay',
        'ovo',
        'dana',
        'shopeepay',
    ],
];
