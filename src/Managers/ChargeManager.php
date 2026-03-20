<?php

namespace Nelsius\Managers;

use Nelsius\NelsiusClient;

class ChargeManager
{
    private NelsiusClient $client;

    public function __construct(NelsiusClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new direct charge
     *
     * @param array $data The charge data
     * @return array The response from the API
     */
    public function create(array $data): array
    {
        return $this->client->request('POST', '/charges', $data);
    }

    /**
     * Get a direct charge by ID
     *
     * @param string $id The charge ID
     * @return array The response from the API
     */
    public function get(string $id): array
    {
        return $this->client->request('GET', "/charges/$id");
    }

    /**
     * Get the list of payment methods
     *
     * @param array $filters Filters for the request
     * @return array The response from the API
     */
    public function methods(array $filters = []): array
    {
        return $this->client->request('GET', '/payment-methods', $filters);
    }
}
