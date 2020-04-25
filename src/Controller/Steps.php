<?php

namespace Wead\Controller;

use Wead\Model\Steps as ModelSteps;

final class Steps
{
    public $config;
    public $steps;

    public function __construct()
    {
        $this->config = $this->retrieveSteps();
        $this->steps = $this->config->steps;

        unset($this->config->steps);
    }

    private function retrieveSteps(): \stdClass
    {
        $data = new ModelSteps();
        return $data->getAll();
    }

    /**
     * Retornar apenas propriedades públicas
     */
    public function __get($key)
    {
        $r = new \ReflectionObject($this);

        if ($r->hasConstant($key)) {
            return $r->getConstant($key);
        }
    }
}