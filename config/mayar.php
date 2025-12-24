<?php

return [
    'api_key' => env('MAYAR_API_KEY'),
    'environment' => env('MAYAR_ENVIRONMENT', 'production'),

    // ✅ Perbaikan: tanpa spasi, tanpa /hl/v1
    'base_url' => env('MAYAR_ENVIRONMENT', 'production') === 'production'
        ? 'https://api.mayar.id'
        : 'https://api.mayar.club',

    'callback_url' => rtrim(env('MAYAR_CALLBACK_URL'), ' '),
    'return_url' => rtrim(env('MAYAR_RETURN_URL'), ' '),

    'link_expiry_hours' => 24,
    'auto_activate_subscription' => true,

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
