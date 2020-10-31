<?php

namespace Legalworks\IsbnTools\Contracts;

interface BookApiContract
{
    public function find(string $identifier);
    public function first(string $query);
    public function search(string $query);
}
