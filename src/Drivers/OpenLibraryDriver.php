<?php

namespace Legalworks\IsbnTools\Drivers;

use Legalworks\IsbnTools\Contracts\BookApiContract;
use Legalworks\IsbnTools\Sources\BeckShop\Client;

class BeckShopDriver implements BookApiContract
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function find(string $identifier)
    {
        return $this->client->getItem($identifier);
    }

    public function first(string $identifier, string $key = 'isbn')
    {
        return $this->search($identifier)->first();
    }

    public function search(string $query)
    {
        return $this->client->search($query);
    }
}
