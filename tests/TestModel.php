<?php

namespace Legalworks\IsbnTools\Tests;

use Illuminate\Database\Eloquent\Model;
use Legalworks\IsbnTools\IsbnCast;

class TestModel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'isbn' => IsbnCast::class,
    ];
}
