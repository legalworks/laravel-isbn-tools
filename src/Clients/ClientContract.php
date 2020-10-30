<?php

namespace Legalworks\IsbnTools\Clients;

abstract class ClientContract
{
    protected $client;

    abstract public function find(string $identifier, string $key = 'isbn');
}
