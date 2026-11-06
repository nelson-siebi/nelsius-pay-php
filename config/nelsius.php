<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Nelsius Pay API Credentials
    |--------------------------------------------------------------------------
    |
    | Obtenez vos clés API depuis votre tableau de bord NelsiusPay
    | https://nelsiuspay.com/dashboard/settings/api-keys
    |
    */

    'public_key' => env('NELSIUS_PUBLIC_KEY', ''),
    'secret_key' => env('NELSIUS_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Base API URL
    |--------------------------------------------------------------------------
    |
    | URL de base de l'API NelsiusPay (Production par défaut)
    |
    */

    'base_url' => env('NELSIUS_BASE_URL', 'https://api.nelsiuspay.com/api/v1'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Signing Secret
    |--------------------------------------------------------------------------
    |
    | Secret de signature pour vérifier les webhooks entrants
    |
    */

    'webhook_secret' => env('NELSIUS_WEBHOOK_SECRET', ''),

    'timeout' => env('NELSIUS_TIMEOUT', 30),
];
