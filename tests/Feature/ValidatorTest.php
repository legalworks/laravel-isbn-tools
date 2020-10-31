<?php

namespace Legalworks\IsbnTools\Tests\Feature;

use Legalworks\IsbnTools\IsbnValidator;
use Orchestra\Testbench\TestCase;

class ValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_isbn()
    {
        $validationRule = ['isbn' => [new IsbnValidator]];

        // ISBN-13
        $this->assertFalse(validator(['isbn' => '1'], $validationRule)->passes());
        $this->assertFalse(validator(['isbn' => 'abc'], $validationRule)->passes());
        $this->assertFalse(validator(['isbn' => 'ISBN13 9783800656370'], $validationRule)->passes());

        $this->assertTrue(validator(['isbn' => '9783800656370'], $validationRule)->passes());
        $this->assertTrue(validator(['isbn' => '978-3-8006-5637-0'], $validationRule)->passes());
        $this->assertTrue(validator(['isbn' => '9-7-8-3-8-0-0-6--5-6-3-7-0'], $validationRule)->passes());
        $this->assertTrue(validator(['isbn' => '978.0.596.52068.7'], $validationRule)->passes());

        // ISBN-10
        $this->assertTrue(validator(['isbn' => '380065637X'], $validationRule)->passes());
    }
}
