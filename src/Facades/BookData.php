<?php

namespace Legalworks\IsbnTools\Facades;

use Illuminate\Support\Facades\Facade;

class BookData extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'book-datas';
    }
}
