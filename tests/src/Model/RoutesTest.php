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
            'to' => 'REC',
            'price' => 1
        ];

        $route = (object) array_values($data);
        $route = new Route($route);

        $model = new Routes();

        $reflect = new \ReflectionObject($model);

        $property = $reflect->getProperty('src');
        $property->setAccessible(true);
        $property->setValue($model, tempnam(sys_get_temp_dir(), rand(0, 10) . 'route.csv'));

        $insert = $model->insert($route);

        $this->assertNull($insert);
        $this->assertContains((array) $route, [(array) $model->getAll()[0]]);
    }
}
