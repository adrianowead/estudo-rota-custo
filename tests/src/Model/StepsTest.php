<?php

namespace Wead\Tests\Model;

use PHPUnit\Framework\TestCase;
use Wead\Controller\dto\Step;
use Wead\Model\Steps;

class StepsTest extends TestCase
{
    public function testGetAll()
    {
        $model = new Steps;

        $this->assertInstanceOf(
            \stdClass::class,
            $model->getAll()
        );
    }

    public function testGetAllContainsSteps()
    {
        $model = new Steps;

        $this->assertContainsOnlyInstancesOf(
            Step::class,
            $model->getAll()->steps
        );
    }
}