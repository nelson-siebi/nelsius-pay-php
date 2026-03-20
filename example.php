<?php

require_once __DIR__ . '/vendor/autoload.php';

use Nelsius\NelsiusClient;

// Initialize the client
$client = new NelsiusClient([
    'api_key' => 'YOUR_API_KEY_HERE',
    'base_url' => 'https://api.nelsius.com/api/v1', // Real API URL
    'timeout' => 30
]);

try {
    // 1. Get Payment Methods
    echo "Fetching payment methods...\n";
    $methods = $client->charges->getPaymentMethods();
    print_r($methods);

    // 2. Get Balance
    echo "\nFetching balance...\n";
    $balance = $client->balance->get();
    print_r($balance);

    // 3. Create Checkout Session
    echo "\nCreating checkout session...\n";
    $session = $client->checkout->createSession([
        'amount' => 1000,
        'currency' => 'XOF',
        'description' => 'Test Payment',
        'success_url' => 'https://example.com/success',
        'cancel_url' => 'https://example.com/cancel',
        'customer_email' => 'customer@example.com'
    ]);
    print_r($session);

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
