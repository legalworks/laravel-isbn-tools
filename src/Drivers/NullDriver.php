<?php

namespace Legalworks\IsbnTools\Drivers;

use Legalworks\IsbnTools\Contracts\BookApiContract;
use Legalworks\IsbnTools\Sources\BeckShop\Client;

class NullDriver implements BookApiContract
{
    public function find(string $identifier)
    {
        return null;
    }

    public function first(string $query, string $key = 'isbn')
    {
        return null;
    }

    public function search(string $query)
    {
        return null;
    }
}
