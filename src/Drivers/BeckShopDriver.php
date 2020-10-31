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

    public function first(string $query, string $key = 'isbn')
    {
        $item = collect($this->client->search($query))->first();

        return $this->client->details($item['id']);
    }

    public function search(string $query)
    {
        $items = $this->client->search($query);

        return collect($items)
            ->map(fn ($item) => $this->client->details($item['id']));
    }
}
