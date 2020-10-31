<?php

namespace Legalworks\IsbnTools\Services;

use Illuminate\Support\Manager;
use Legalworks\IsbnTools\Contracts\BookApiContract;
use Legalworks\IsbnTools\Drivers\BeckShopDriver;
use Legalworks\IsbnTools\Drivers\GoogleBooksDriver;
use Legalworks\IsbnTools\Drivers\NullDriver;

class BookDataManager extends Manager
{
    public function using(string $driver): BookApiContract
    {
        return $this->driver($driver);
    }

    public function createNullDriver()
    {
        return new NullDriver;
    }

    public function createBeckShopDriver()
    {
        return new BeckShopDriver;
    }

    public function createDnbSruDriver()
    {
        return new NullDriver;
    }

    public function createGoogleBooksDriver()
    {
        return new GoogleBooksDriver;
    }

    public function getDefaultDriver()
    {
        return config('legalworks-isbntools.default_client') ?? null;
    }
}
