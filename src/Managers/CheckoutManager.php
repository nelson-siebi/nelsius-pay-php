<?php

namespace Nelsius\Managers;

use Nelsius\NelsiusClient;

class CheckoutManager
{
    private NelsiusClient $client;

    public function __construct(NelsiusClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new hosted checkout session
     *
     * @param array $data The checkout data
     * @return array The response from the API
     */
    public function createSession(array $data): array
    {
        return $this->client->request('POST', '/checkout/sessions', $data);
    }
}
