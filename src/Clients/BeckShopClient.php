<?php

namespace Legalworks\IsbnTools\Clients;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Legalworks\IsbnTools\Sources\BeckShop\Client;

class BeckShopClient extends ClientContract
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function find(string $identifier, string $key = 'ISBN')
    {
        dd($this->client->search('Palandt'));
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
