<?php

namespace Wead\Model;

use Wead\Controller\dto\Step;

// emulando algo como um model de acesso ao banco de dados
final class Steps
{
    private $src;

    public function __construct()
    {
        $this->src = getcwd() . DIRECTORY_SEPARATOR . "steps.json";
    }

    public function getAll(): \stdClass
    {
        $tmp = json_decode(file_get_contents($this->src));

        foreach ($tmp->steps as $k => $v) {
            $tmp->steps[$k] = new Step($v);
        }

        return $tmp;
    }
}
