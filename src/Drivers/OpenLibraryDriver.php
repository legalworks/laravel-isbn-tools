<?php

namespace Legalworks\IsbnTools\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Legalworks\IsbnTools\Contracts\BookApiContract;
use Legalworks\IsbnTools\Sources\BeckShop\Client;

class BeckShopDriver implements BookApiContract
{
    protected Http $client;

    public function __construct()
    {
        $this->client = Http::withOptions([
            'base_uri' => 'https://www.beck-shop.de',
        ]);
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

    protected static function map(array $item)
    {
        $item = collect($item);
        return [
            'title' => $item['details']['title'],
            'subtitle' => $item['details']['subtitle'],
            'authors' => $item['details']['authors'],
            'publishers' => $item['details']['publishers'],
            'publish_date' => new Carbon($item['details']['publish_date']),
            'physical_format' => $item['details']['physical_format'],
            'number_of_pages' => $item['details']['number_of_pages'],
            'cover' => "https://covers.openlibrary.org/b/id/{$item['details']['covers'][0]}-L.jpg",
            'key' => trim($item['details']['key'], '/'),
        ];
    }
}
