<?php

namespace Wead\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Wead\Helper\ExtractStarWars;

class ExtractStarWarsTest extends TestCase
{
    public function testGetContent()
    {
        $content = ExtractStarWars::getContent();

        $this->assertStringContainsString('E p i s o d e I V', $content);
    }
}
