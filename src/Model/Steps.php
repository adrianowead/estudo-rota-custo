<?php

namespace Wead\Model;

use Wead\Controller\dto\Step;
use Wead\Controller\dto\StepConfig;

// emulando algo como um model de acesso ao banco de dados
final class Steps
{
    private $src;

    public function __construct()
    {
        $this->src = getcwd() . DIRECTORY_SEPARATOR . "steps.json";
    }

    public function getAll(): \SplObjectStorage
    {
        $tmp = json_decode(file_get_contents($this->src));
        $out = new \SplObjectStorage();

        foreach ($tmp->steps as $v) {
            $out->attach(new Step($v));
        }

        return $out;
    }

    public function getConfig(): StepConfig
    {
        $tmp = json_decode(file_get_contents($this->src));

        $out = new StepConfig();

        foreach (array_keys(get_object_vars($out)) as $k) {
            $out->{$k} = $tmp->{$k};
        }

        return $out;
    }
}
