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

    public function getAll(): array
    {
        $data = [];

        $file = fopen($this->src, "r");

        while (($row = fgetcsv($file, 1000, ",")) !== false) {
            $data[] = new Route((object) $row);
        }

        fclose($file);

        return $data;
    }
}
