<?php

namespace Legalworks\LaravelIsbnTools\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelIsbnTools extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelisbntools';
    }
}
