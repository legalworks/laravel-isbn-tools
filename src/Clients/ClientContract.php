<?php

namespace Legalworks\IsbnTools\Clients;

abstract class ClientContract
{
    abstract public function find(string $identifier, string $key = 'isbn');
}
