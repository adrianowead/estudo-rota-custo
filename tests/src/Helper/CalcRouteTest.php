<?php

namespace Wead\Test\Helper;

use PHPUnit\Framework\TestCase;
use Wead\Helper\CalcRoute;

class CalcRouteTest extends TestCase
{
    public function testRouteAssemble()
    {
        $mock = $this->getMockForTrait(CalcRoute::class);

        $reflect = new \ReflectionObject($mock);
        $method = $reflect->getMethod('routeAssemble');
        $method->setAccessible(true);

        $out = $method->invoke($mock);

        $expected = chr(13) . chr(10) . "GRU -> POA -> CXJ";

        $this->assertEquals($expected, $out);
    }

    public function testTripType()
    {
        $mock = $this->getMockForTrait(CalcRoute::class);

        $reflect = new \ReflectionObject($mock);
        $method = $reflect->getMethod('tripType');
        $method->setAccessible(true);

        $out = $method->invoke($mock);

        $expected = "com escala";

        $this->assertEquals($expected, $out);
    }

    public function testPerformCalc()
    {
        $mock = $this->getMockForTrait(CalcRoute::class);

        $reflect = new \ReflectionObject($mock);
        $method = $reflect->getMethod('performCalc');
        $method->setAccessible(true);

        $out = $method->invoke($mock);

        $expected = "R$ 15,00";

        $this->assertEquals($expected, $out);
    }
}
