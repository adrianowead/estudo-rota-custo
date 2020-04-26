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

    public function testCheckTripPossible()
    {
        $web = new Web();

        $this->assertNull($web->checkTripPossible());
    }

    public function testRender()
    {
        $web = new Web();

        ob_start();
        $web->render();
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }
}
