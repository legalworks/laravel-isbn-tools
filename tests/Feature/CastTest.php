<?php

namespace Legalworks\IsbnTools\Tests\Feature;

use Legalworks\IsbnTools\Tests\TestModel;
use Orchestra\Testbench\TestCase;

class CastTest extends TestCase
{
    /** @test */
    public function it_casts_isbn()
    {
        $model = new TestModel();

        $model->isbn = '9783-8006-5637-0';

        dd($model);
        $this->assertTrue($model->isbn === '978-3-8006-5637-0');

        // check in DB
    }
}
