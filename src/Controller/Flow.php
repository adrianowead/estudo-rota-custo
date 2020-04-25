<?php

namespace Wead\Controller;

use Wead\Controller\dto\Step;

abstract class Flow
{
    private $steps;
    public $config;

    public function __construct()
    {
        $data = new Steps;

        $this->steps = $data->steps;
        $this->config = $data->config;
    }

    public function getCurrentStep(): Step
    {
        return current($this->steps);
    }

    public function getNextStep(): Step
    {
        return next($this->steps);
    }

    public function getPreviusStep(): Step
    {
        return prev($this->steps);
    }

    public function setStep(int $step = 0): Step
    {
        while ($this->getCurrentStep()->id < $step) {
            $this->getNextStep();
        }

        return $this->getCurrentStep();
    }

    abstract public function dispatchInput();
}