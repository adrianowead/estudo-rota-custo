<?php

namespace Wead\Helper;

use Wead\Controller\dto\Route;
use Wead\Model\Routes;

trait CalcRoute
{
    private $from;
    private $to;
    private $routes;
    private $allMatch;

    public function __construct()
    {
        parent::__construct();

        $model = new Routes;

        $this->routes = $model->getAll();
    }

    private function routeAssemble(): array
    {
        $allFrom = $this->findAllOutliers($this->inputs['%pontoOrigem%'], $this->routes, 'from');
        $allMatch = $this->pathFinder($allFrom);

        foreach ($allMatch as $k => $path) {
            $total = 0;

            foreach ($path as $item) {
                $total += $item->value;
            }

            $this->allMatch[$total] = $path;
        }

        if (!$this->allMatch) {
            return [];
        }

        ksort($this->allMatch);

        $route = $this->allMatch[key($this->allMatch)];
        $path = [];

        foreach ($route as $k => $item) {
            if (end($route) == $item) {
                $path[] = $item->from;
                $path[] = $item->to;
            } else {
                $path[] = $item->from;
            }
        }

        return $path;
    }

    private function tripType(): string
    {
        if (!$this->allMatch) {
            return "";
        }

        return sizeof($this->allMatch[key($this->allMatch)]) > 1 ? "com escala" : "direto";
    }

    private function getTotalValue(): string
    {
        if (!$this->allMatch) {
            return "";
        }

        return "R$ " . number_format(key($this->allMatch), 2, ',', '.');
    }

    private function findAllOutliers(string $code, array $routes, $type = null): array
    {
        return array_filter($routes, function ($route) use ($code, $type) {
            return (($route->from == $code && (!$type || $type == 'from')) || ($route->to == $code && (!$type || $type == 'to')));
        });
    }

    private function pathFinder(array $from): array
    {
        $paths = [];

        foreach ($from as $item) {
            $line = array_values($this->followBreadcrumb($item));

            if (sizeof($line) > 1) {
                if ($line[0]->from == $this->inputs['%pontoOrigem%'] && end($line)->to == $this->inputs['%pontoDestino%']) {
                    $paths[] = $line;
                }
            }
        }

        return $paths;
    }

    private function followBreadcrumb(Route $start): array
    {
        $list = [$start];

        while ($current = $this->findAllOutliers($start->to, $this->routes, 'from')) {
            $start = array_shift($current);

            $list[] = $start;

            if ($start->to == $this->inputs['%pontoDestino%']) {
                break;
            }
        }

        return $list;
    }
}