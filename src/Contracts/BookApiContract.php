<?php

namespace Legalworks\IsbnTools\Contracts;

interface BookApiContract
{
    public function find(string $identifier);
    public function first(string $identifier, string $key = 'isbn');
    public function search(string $query);
}
