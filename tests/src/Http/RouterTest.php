<?php

namespace Wead\Tests\Http;

use Wead\Http\Router;
use Wead\Http\Request;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testFormatRoute()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["SERVER_PROTOCOL"] = "HTTP";
        $_SERVER["REQUEST_URI"] = "/";

        $route = new Router(new Request());
        $route->get('/', function () {
        });

        $reflect = new \ReflectionObject($route);
        $method = $reflect->getMethod('formatRoute');
        $method->setAccessible(true);

        $out = $method->invoke($route, "/teste/");

        $this->assertEquals("/teste", $out);
    }

    public function testParamsRoute()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["SERVER_PROTOCOL"] = "HTTP";
        $_SERVER["REQUEST_URI"] = "/t/nome";

        $route = new Router(new Request());
        $route->get('/t/{param}', function () {
        });

        $reflect = new \ReflectionObject($route);
        $method = $reflect->getMethod('formatRoute');
        $method->setAccessible(true);

        $out = $method->invoke($route, "/teste/");

        $this->assertEquals("/teste", $out);
    }
}
