<?php

namespace Wead\Test\Controller;

use PHPUnit\Framework\TestCase;
use Wead\Controller\Steps;

class StepTest extends TestCase
{
    public function testGetUndefinedProperty()
    {
        $steps = new Steps;

        $this->assertNull($steps->testNullReturn);
    }

    public function testGetPublicProperty()
    {
        $steps = new Steps;

        $this->assertNotEmpty($steps->steps);
    }
}