<?php

namespace Wead\Tests;

use Wead\Boostrap;
use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testRunCli()
    {
        $run = new Boostrap();

        $this->assertNull($run->run('cli'));
    }
}
