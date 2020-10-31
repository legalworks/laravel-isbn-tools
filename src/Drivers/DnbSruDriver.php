<?php

namespace Legalworks\IsbnTools\Drivers;

use Legalworks\IsbnTools\Clients\SruClient;
use Legalworks\IsbnTools\Contracts\BookApiContract;
use Legalworks\IsbnTools\Sources\BeckShop\Client;

class DnbSruDriver implements BookApiContract
{
    protected SruClient $client;

    public function __construct()
    {
        $this->client = new SruClient([
            'base_uri' => config('legalworks-isbntools.clients.DnbSru.url'),
            'query' => [
                'accessToken' => config('legalworks-isbntools.clients.DnbSru.token'),
            ],
        ]);
    }

    public function find(string $identifier)
    {
        return $this->client->getItem($identifier);
    }

    public function first(string $query)
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
