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

    public function reloadRoutes()
    {
        $model = new Routes();

        $this->routes = $model->getAll();
    }

    private function routeAssemble(): array
    {
        $this->reloadRoutes();

        $allFrom = $this->findAllOutliers($this->from, $this->routes, 'from');
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

    private function getTotalValue($formated = true): string
    {
        if (!$this->allMatch) {
            return "";
        }

        if ($formated) {
            return "R$ " . number_format(key($this->allMatch), 2, ',', '.');
        } else {
            return key($this->allMatch);
        }
    }

    private function findAllOutliers(string $code, \SplObjectStorage $routes, $type = null): \SplStack
    {
        $found = new \SplStack();

        while ($routes->valid()) {
            if (
                ($routes->current()->from == $code && (!$type || $type == 'from')) ||
                ($routes->current()->to == $code && (!$type || $type == 'to'))
            ) {
                $found->push($routes->current());
            }

            $routes->next();
        }

        $found->rewind();

        return $found;
    }

    private function pathFinder(\SplStack $from): \SplObjectStorage
    {
        $paths = new \SplObjectStorage();

        while ($from->valid()) {
            $line = $this->followBreadcrumb($from->current());

            if ($line->count() > 1) {
                if ($line->shift()->from == $this->from && $line->pop()->to == $this->to) {
                    $paths->attach($line->current());
                }
            }

            $from->next();
        }

        $paths->rewind();

        return $paths;
    }

    private function followBreadcrumb(Route $start): \SplStack
    {
        $list = new \SplStack();
        $list->push($start);

        $current = $this->findAllOutliers($start->to, $this->routes, 'from');

        while ($current->valid()) {
            ;
            $start = $current->shift();

            $list->push($start);

            if ($start->to == $this->to) {
                break;
            }

            $current->next();
        }

        return $list;
    }
}
