<?php

namespace Wead\Model;

use Wead\Controller\dto\Route;

// emulando algo como um model de acesso ao banco de dados
final class Routes
{
    private $src;

    public function __construct()
    {
        $this->src = getcwd() . DIRECTORY_SEPARATOR . "exemplo.csv";
    }

    public function getAll(): \SplObjectStorage
    {
        $data = new \SplObjectStorage();

        $file = fopen($this->src, "r");

        while (($row = fgetcsv($file, 1000, ",")) !== false) {
            $data->attach(new Route((object) $row));
        }

        fclose($file);

        $data->rewind();

        return $data;
    }

    public function insert(Route $route): void
    {
        if (!$this->getAll()->contains($route)) {
            $file = fopen($this->src, "a+");
            fputcsv($file, (array) $route);
            fclose($file);
        }
    }
}
