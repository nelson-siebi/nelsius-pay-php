<?php

require_once __DIR__ . '/vendor/autoload.php';

use Nelsius\NelsiusClient;

// Initialize the client
$client = new NelsiusClient('YOUR_API_KEY_HERE', [
    'base_url' => 'https://api.nelsius.com/api/v1', // Real API URL
    'timeout' => 30,
    'verify_ssl' => false // Set to true in production
]);

try {
    // 1. Get Payment Methods
    echo "1. Fetching payment methods...\n";
    $methods = $client->charges->methods(['country' => 'CM', 'currency' => 'XAF']);
    print_r($methods);

    // 2. Get Balance
    echo "\n2. Fetching balance...\n";
    $balance = $client->balance->get();
    print_r($balance);

    // 3. Create Hosted Checkout Session
    echo "\n3. Creating checkout session...\n";
    $session = $client->checkout->createSession([
        'amount' => 5000,
        'currency' => 'XAF',
        'reference' => 'ORDER_' . time(),
        'description' => 'Test PHP SDK Purchase',
        'return_url' => 'https://example.com/success',
        'cancel_url' => 'https://example.com/cancel',
        'customer' => [
            'email' => 'client@example.com',
            'name' => 'Jean Dupont'
        ]
    ]);
    echo "Checkout URL: " . $session['data']['checkout_url'] . "\n";

    // 4. Create Direct Charge (Mobile Money)
    echo "\n4. Creating direct charge...\n";
    $charge = $client->charges->create([
        'amount' => 1000,
        'currency' => 'XAF',
        'method' => 'mobile_money',
        'operator' => 'mtn_money',
        'customer_phone' => '+237670000000',
        'reference' => 'REF_' . time()
    ]);
    print_r($charge);

    // 5. Get Transaction Status
    if (isset($charge['data']['id'])) {
        echo "\n5. Checking transaction status...\n";
        $status = $client->charges->get($charge['data']['id']);
        print_r($status);
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
