<?php

namespace Legalworks\IsbnTools\Services;

use Illuminate\Support\Manager;
use Legalworks\IsbnTools\Contracts\BookApiContract;
use Legalworks\IsbnTools\Drivers\BeckShopDriver;
use Legalworks\IsbnTools\Drivers\DnbSruDriver;
use Legalworks\IsbnTools\Drivers\GoogleBooksDriver;
use Legalworks\IsbnTools\Drivers\NullDriver;

class BookDataManager extends Manager
{
    public function from(string $driver): BookApiContract
    {
        return $this->driver($driver);
    }

    public function createNullDriver(): BookApiContract
    {
        return new NullDriver;
    }

    public function createBeckShopDriver(): BookApiContract
    {
        return new BeckShopDriver;
    }

    public function createDnbSruDriver(): BookApiContract
    {
        return new DnbSruDriver;
    }

    public function createGoogleBooksDriver(): BookApiContract
    {
        return new GoogleBooksDriver;
    }

    public function getDefaultDriver(): string
    {
        return config('legalworks-isbntools.default_client') ?? null;
    }
}
