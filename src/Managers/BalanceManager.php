<?php

namespace Nelsius\Managers;

use Nelsius\NelsiusClient;

class BalanceManager
{
    private NelsiusClient $client;

    public function __construct(NelsiusClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get the merchant balance
     *
     * @return array The response from the API
     */
    public function get(): array
    {
        return $this->client->request('GET', '/balance');
    }
}
