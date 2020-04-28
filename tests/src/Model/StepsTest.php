<?php

namespace Wead\Tests\Model;

use PHPUnit\Framework\TestCase;
use Wead\Controller\dto\Step;
use Wead\Controller\dto\StepConfig;
use Wead\Model\Steps;

class StepsTest extends TestCase
{
    public function testGetAll()
    {
        $model = new Steps();

        $this->assertInstanceOf(
            \SplObjectStorage::class,
            $model->getAll()
        );
    }

    public function testGetConfig()
    {
        $model = new Steps();

        $this->assertInstanceOf(
            StepConfig::class,
            $model->getConfig()
        );
    }
}
