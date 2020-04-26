<?php

namespace Wead\Tests;

use PHPUnit\Framework\TestCase;
use Wead\Boostrap;

class BootstrapTest extends TestCase
{
    public function testRunCli()
    {
        $run = new Boostrap();

        $this->assertNull($run->run('cli'));
    }

    public function testRunWeb()
    {
        $run = new Boostrap();

        ob_start();
        $run->run('web');
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }
}
