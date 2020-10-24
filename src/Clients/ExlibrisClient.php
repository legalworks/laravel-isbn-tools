<?php

namespace Legalworks\IsbnTools\Clients;

use Scriptotek\Sru\Client as SruClient;

class ExlibrisClient extends ClientContract
{
    protected $client;

    protected string $base_url = 'http://bibsys-network.alma.exlibrisgroup.com/view/sru/47BIBSYS_NETWORK';

    public function __construct()
    {
        $this->client = new SruClient($this->base_url, [
            'schema' => 'marcxml',
            'version' => '1.2',
            'user-agent' => 'MyTool/0.1',
        ]);
    }

    public function find(string $identifier, string $key = 'isbn')
    {
        if ($key === 'isbn') {
            $identifier = preg_replace('/[^xX0-9]/', '', $identifier);
        }

        $record = $this->client->first("alma.{$key}=\"{$identifier}\"");

        dd($record->json());
    }
}
