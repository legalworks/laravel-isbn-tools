<?php

namespace Legalworks\IsbnTools\Clients;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Legalworks\IsbnTools\Sources\DnbSru\Client;

class DnbSruClient extends ClientContract
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function find(string $identifier, string $key = 'ISBN')
    {
        dd($this->client->first($identifier));


        dd($this->client->first('%22Deutsche%20Nationalbibliothek%22'));
        dd($this->client->first('dnb.isbn="' . $identifier . '"'));
        if ($key === 'ISBN') {
            $identifier = preg_replace('/[^xX0-9]/', '', $identifier);
        }

        $url = sprintf("{$this->base_url}books?bibkeys=%s:%s&jscmd=details&format=json", $key, $identifier);

        $response = Http::get($url);

        $items = collect($response->json())
            ->values()
            ->map(fn ($item) => self::map($item));
        dd($items, $response->json());
        // foreach($response->json()->first);
        dd(self::map($response->json()));

        dd($response->body()[0]);
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
