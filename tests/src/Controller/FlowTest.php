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
}
