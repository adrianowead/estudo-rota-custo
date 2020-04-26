<?php

namespace Wead\Tests\Model;

use PHPUnit\Framework\TestCase;
use Wead\Controller\dto\Route;
use Wead\Model\Routes;

class RoutesTest extends TestCase
{
    public function testGetAll()
    {
        $model = new Routes();

        $this->assertIsArray($model->getAll());
    }

    public function testGetAllContainsSteps()
    {
        $model = new Routes();

        $this->assertContainsOnlyInstancesOf(
            Route::class,
            $model->getAll()
        );
    }

    public function testInsertNew()
    {
        $data = [
            'from' => 'GRU',
            'to' => 'BRC',
            'price' => 10
        ];

        $route = (object) array_values($data);
        $route = new Route($route);

        $model = new Routes();

        $insert = $model->insert($route);

        $this->assertNull($insert);
    }
}
