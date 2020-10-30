<?php

namespace Legalworks\IsbnTools\Drivers;

use Legalworks\IsbnTools\Contracts\BookApiContract;

class NullDriver implements BookApiContract
{
    public function find(string $identifier)
    {
        return null;
    }

    public function first(string $identifier, string $key = 'isbn')
    {
        return null;
    }

    public function search(string $query)
    {
        return null;
    }
}
