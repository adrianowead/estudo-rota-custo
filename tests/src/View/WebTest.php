<?php

namespace Wead\Test\View;

use PHPUnit\Framework\TestCase;
use Wead\View\Web;

class WebTest extends TestCase
{
    public function testDispatchInput()
    {
        $web = new Web();

        $this->assertNull($web->dispatchInput());
    }
}
