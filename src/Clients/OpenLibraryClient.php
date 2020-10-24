<?php

namespace Legalworks\IsbnTools\Clients;

use Illuminate\Support\Facades\Http;

class OpenLibraryClient extends ClientContract
{
    protected string $base_url = 'https://openlibrary.org/api/';

    public function find(string $identifier, string $key = 'ISBN')
    {
        if ($key === 'ISBN') {
            $identifier = preg_replace('/[^xX0-9]/', '', $identifier);
        }

        $url = sprintf("{$this->base_url}books?bibkeys=%s:%s&jscmd=details&format=json", $key, $identifier);

        $response = Http::get($url);

        dd($response->json());
    }
}
