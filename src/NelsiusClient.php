<?php

namespace Nelsius;

use Nelsius\Managers\ChargeManager;
use Nelsius\Managers\CheckoutManager;
use Nelsius\Managers\BalanceManager;

class NelsiusClient
{
    private string $apiKey;
    private string $baseUrl;
    private int $timeout;

    public ChargeManager $charges;
    public CheckoutManager $checkout;
    public BalanceManager $balance;

    public function __construct(string $apiKey, array $options = [])
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($options['base_url'] ?? 'https://api.nelsius.com/api/v1', '/');
        $this->timeout = $options['timeout'] ?? 30;

        // Initialize Managers
        $this->charges = new ChargeManager($this);
        $this->checkout = new CheckoutManager($this);
        $this->balance = new BalanceManager($this);
    }

    /**
     * Execute a request to the Nelsius API
     */
    public function request(string $method, string $path, array $data = []): array
    {
        $url = $this->baseUrl . '/' . ltrim($path, '/');
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
            'X-SDK-Platform: PHP',
            'X-SDK-Version: 1.0.0'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif (strtoupper($method) === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("Nelsius SDK Connection Error: $error");
        }

        $decodedBody = json_decode($response, true);

        if ($httpCode >= 400) {
            $errorMessage = $decodedBody['message'] ?? $decodedBody['error'] ?? 'Unknown Error';
            throw new \Exception("Nelsius API Error ($httpCode): $errorMessage", $httpCode);
        }

        return $decodedBody ?: [];
    }
}
