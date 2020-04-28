<?php

namespace Wead\Test\Controller;

use Wead\Controller\Flow;
use Wead\Controller\dto\Step;
use PHPUnit\Framework\TestCase;

class FlowTest extends TestCase
{
    public function testGetCurrentStep()
    {
        $mock = $this->getMockForAbstractClass(Flow::class);

        $this->assertInstanceOf(
            Step::class,
            $mock->getCurrentStep()
        );
    }

    public function testGetNextStep()
    {
        $mock = $this->getMockForAbstractClass(Flow::class);

        $this->assertInstanceOf(
            Step::class,
            $mock->getNextStep()
        );
    }

    public function testGetPreviusStep()
    {
        $mock = $this->getMockForAbstractClass(Flow::class);

        $reflect = new \ReflectionObject($mock);
        $method = $reflect->getMethod('setStep');
        $method->setAccessible(true);

        $method->invoke($mock, 1);

        $this->assertInstanceOf(
            Step::class,
            $mock->getPreviusStep()
        );
    }

    public function testSetStep()
    {
        $mock = $this->getMockForAbstractClass(Flow::class);

        $this->assertInstanceOf(
            Step::class,
            $mock->setStep(1)
        );
    }

    public function testSetSleep()
    {
        $mock = $this->getMockForAbstractClass(Flow::class);

        $this->assertNull($mock->setSleep(0));
    }

    public function testCleanUpStepMessage()
    {
        $mock = $this->getMockForAbstractClass(Flow::class);

        $step = new Step((object) [
            "id" => null,
            "text" => "teste|1.9| unit",
            "wait" => null,
            "required" => null,
            "namespace" => null,
            "next" => null,
        ]);

        $expected = "teste unit";

        $this->assertEquals($expected, $mock->cleanUpStepMessage($step)->text);
    }
}
