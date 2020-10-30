<?php

namespace Legalworks\IsbnTools\Services;

use Illuminate\Support\Manager;
use Legalworks\IsbnTools\Drivers\BeckShopDriver;
use Legalworks\IsbnTools\Drivers\NullDriver;

class BookDataManager extends Manager
{

    public function from($name = null)
    {
        return $this->driver($name);
    }

    public function createBeckShopDriver()
    {
        return new BeckShopDriver;
    }

    public function createNullDriver()
    {
        return new NullDriver;
    }

    public function getDefaultDriver()
    {
        return config('legalworks-isbntools.default_client') ?? null;
    }
}
