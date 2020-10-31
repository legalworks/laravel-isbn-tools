<?php

namespace Legalworks\IsbnTools\Facades;

use Illuminate\Support\Facades\Facade;

class IsbnTools extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'isbn-tools';
    }
}
