<?php

namespace Legalworks\IsbnTools\Clients;

use Legalworks\IsbnTools\Sources\Exlibris\Client;

class ExlibrisClient extends ClientContract
{
    protected $client;

    protected string $base_url = 'http://bibsys-network.alma.exlibrisgroup.com/view/sru/47BIBSYS_NETWORK';

    public function __construct()
    {
        $this->client = new Client;
    }

    public function find(string $identifier, string $key = 'isbn')
    {
        dd($this->client->first($identifier));

        if ($key === 'isbn') {
            $identifier = preg_replace('/[^xX0-9]/', '', $identifier);
        }

        $record = $this->client->first("alma.{$key}=\"{$identifier}\"");

        dd($record->json());
    }
}
