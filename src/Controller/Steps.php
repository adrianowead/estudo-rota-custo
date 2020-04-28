<?php

namespace Wead\Controller;

use Wead\Controller\dto\StepConfig;
use Wead\Model\Steps as ModelSteps;

final class Steps
{
    private $config;
    public $steps;

    public function __construct()
    {
        $this->steps = $this->retrieveSteps();
        $this->config = $this->retrieveConfig();
    }

    private function retrieveSteps(): \SplObjectStorage
    {
        $data = new ModelSteps();
        $data = $data->getAll();
        $data->rewind();

        return $data;
    }

    private function retrieveConfig(): StepConfig
    {
        $data = new ModelSteps();
        return $data->getConfig();
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Retornar apenas propriedades públicas
     */
    public function __get($key)
    {
        $r = new \ReflectionObject($this);

        if ($r->hasProperty($key)) {
            return $r->hasProperty($key);
        }
    }
}
