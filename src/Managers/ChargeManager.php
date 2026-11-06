<?php

namespace Nelsius\Managers;

use GuzzleHttp\Client;
use RuntimeException;

class ChargeManager
{
    public function __construct(private readonly Client $http) {}

    /**
     * Déclenche un paiement direct USSD (Mobile Money).
     *
     * @param array{
     *   amount: float|int,
     *   currency: string,
     *   phone: string,
     *   operator: string,
     *   reference?: string
     * } $payload
     * @return array
     * @throws RuntimeException
     */
    public function create(array $payload): array
    {
        $response = $this->http->post('payments/charge', [
            'json' => $payload
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() >= 400) {
            throw new RuntimeException('Nelsius API Error: ' . json_encode($data));
        }

        return $data;
    }

    /**
     * Vérifie le statut d'un paiement.
     *
     * @param string $reference
     * @return array
     * @throws RuntimeException
     */
    public function getStatus(string $reference): array
    {
        $response = $this->http->get('payments/' . urlencode($reference));
        
        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() >= 400) {
            throw new RuntimeException('Nelsius API Error: ' . json_encode($data));
        }

        return $data;
    }
}
