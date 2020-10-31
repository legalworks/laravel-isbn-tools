<?php

namespace Legalworks\IsbnTools\Clients;

use Carbon\Carbon;
use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;
use File;
use Illuminate\Support\Facades\Http;
use Legalworks\IsbnTools\Sources\DnbSru\SruRecord;
use Legalworks\IsbnTools\Sources\DnbSru\SruRecords;
use Scriptotek\Marc\Collection as MarcCollection;
use Storage;

class BeckShopClient
{
    protected $client;

    public function __construct()
    {
        $this->client = Http::withOptions([
            'base_uri' => 'https://www.beck-shop.de',
            'headers' => [
                'User-Agent' => 'Lex/0.1',
            ],
        ]);
    }

    public function search(string $query)
    {
        $uri = "suche?query={$query}";

        $response = $this->client->query($uri);

        return $response->body();
    }

    public function find(string $identifier)
    {
        $response = $this->client->query("product/{$identifier}");

        return $response->body();
    }

    protected function query(string $uri)
    {
        $response = $this->client->get($uri);


        dd($response->body());
        return $response->body();
    }
}
