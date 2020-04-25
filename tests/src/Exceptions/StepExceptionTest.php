<?php

namespace Wead\Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use Wead\Exceptions\StepException;

class StepExeptionTest extends TestCase
{
    public function testToString()
    {
        $exception = new StepException("Test", 123);

        $expected = "Wead\Exceptions\StepException: [123]: Test\n";

        $this->assertEquals($expected, $exception->__toString());
    }
}