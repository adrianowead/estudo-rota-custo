<?php

namespace Wead\Test\View;

use PHPUnit\Framework\TestCase;
use Wead\View\Cli;

class CliTest extends TestCase
{
    public function testWatchParams()
    {
        $cli = new Cli;

        $reflect = new \ReflectionObject($cli);
        $method = $reflect->getMethod('watchParams');
        $method->setAccessible(true);

        $property = $reflect->getProperty('inputs');
        $property->setAccessible(true);
        $property->setValue($cli, [
            '%pontoOrigem%' => "GRU",
            '%pontoDestino%' => "CXJ",
        ]);

        $out = $method->invoke($cli);

        $expected = null;

        $this->assertEquals($expected, $out);
    }

    public function testReplaceVars()
    {
        $string = "Olá %teste%";
        $expected = "Olá João";

        $cli = new Cli;

        $reflect = new \ReflectionObject($cli);
        $method = $reflect->getMethod('replaceVars');
        $method->setAccessible(true);

        $property = $reflect->getProperty('inputs');
        $property->setAccessible(true);
        $property->setValue($cli, ['%teste%' => "João"]);

        $out = $method->invoke($cli, $string);

        $this->assertEquals($expected, $out);
    }

    public function testTypeCli()
    {
        $string = "Este é um teste";
        $expected = $string . chr(13) . chr(10);

        $cli = new Cli;

        $reflect = new \ReflectionObject($cli);
        $method = $reflect->getMethod('typeCli');
        $method->setAccessible(true);

        ob_start();
        $method->invoke($cli, $string);
        $out = ob_get_clean();

        $this->assertEquals($expected, $out);
    }

    public function testPerformText()
    {
        $string = "Este é um teste|0.001|";
        $expected = "Este é um teste" . chr(13) . chr(10) . chr(13) . chr(10);

        $cli = new Cli;

        $reflect = new \ReflectionObject($cli);
        $method = $reflect->getMethod('performText');
        $method->setAccessible(true);

        ob_start();
        $method->invoke($cli, $string);
        $out = ob_get_clean();

        $this->assertEquals($expected, $out);
    }

    public function testCatchInput()
    {
        $cli = new Cli;

        $reflect = new \ReflectionObject($cli);
        $method = $reflect->getMethod('catchInput');
        $method->setAccessible(true);

        $out = $method->invoke($cli);

        $this->assertEquals("test", $out);
    }

    public function testPersistAsk()
    {
        $cli = new Cli;

        $reflect = new \ReflectionObject($cli);
        $method = $reflect->getMethod('persistAsk');
        $method->setAccessible(true);

        ob_start();
        $method->invoke($cli);
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }

    public function testDispatchInput()
    {
        $cli = new Cli;

        $reflect = new \ReflectionObject($cli);
        $method = $reflect->getMethod('dispatchInput');
        $method->setAccessible(true);

        ob_start();
        $method->invoke($cli);
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }
}