<?php

namespace Nelsius;

use GuzzleHttp\Client;
use Nelsius\Managers\CheckoutManager;
use Nelsius\Managers\ChargeManager;

class NelsiusClient
{
    private Client $httpClient;
    
    public readonly CheckoutManager $checkout;
    public readonly ChargeManager $charges;

    public function __construct(string $apiKey, array $options = [])
    {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('NelsiusClient requires an apiKey.');
        }

        $baseUrl = $options['base_url'] ?? 'https://api.nelsiuspay.com/api/v1';
        $timeout = $options['timeout'] ?? 30;

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'X-SDK-Name'    => 'Nelsius-PHP-V2',
            'X-SDK-Version' => '2.0.0',
        ];

        if (str_starts_with($apiKey, 'pk_')) {
            $headers['X-Api-Key'] = $apiKey;
        } else {
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        }

        $this->httpClient = new Client([
            'base_uri' => rtrim($baseUrl, '/') . '/',
            'timeout'  => $timeout,
            'headers'  => $headers,
            'http_errors' => false, // We will handle them manually
        ]);

        $this->checkout = new CheckoutManager($this->httpClient);
        $this->charges = new ChargeManager($this->httpClient);
    }
}
