<?php

namespace Nelsius\Managers;

use GuzzleHttp\Client;
use RuntimeException;

class CheckoutManager
{
    public function __construct(private readonly Client $http) {}

    /**
     * Crée une session de paiement hébergée.
     *
     * @param array{
     *   amount: float|int,
     *   currency: string,
     *   reference?: string,
     *   customer_email?: string,
     *   customer_phone?: string,
     *   return_url?: string,
     *   cancel_url?: string,
     *   metadata?: array
     * } $payload
     * @return array
     * @throws RuntimeException
     */
    public function createSession(array $payload): array
    {
        $response = $this->http->post('checkout/initiate', [
            'json' => $payload
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() >= 400) {
            throw new RuntimeException('Nelsius API Error: ' . json_encode($data));
        }

        return $data;
    }
}
