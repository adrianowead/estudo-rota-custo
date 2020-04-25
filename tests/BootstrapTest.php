<?php

namespace Wead\Tests;

use PHPUnit\Framework\TestCase;
use Wead\Boostrap;

class BootstrapTest extends TestCase
{
    public function testRun()
    {
        $run = new Boostrap;

        $this->assertNull($run->run(php_sapi_name()));
    }
}