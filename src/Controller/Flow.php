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
        $this->config = $data->getConfig();
    }

    public function getCurrentStep(): Step
    {
        return current($this->steps);
    }

    public function getNextStep(): Step
    {
        $last = clone $this;
        $last = end($last->steps);

        $step = $last === $this->getCurrentStep() ? $last : next($this->steps);

        return $step;
    }

    public function getPreviusStep(): Step
    {
        $first = clone $this;
        $first = array_shift($first->steps);

        $step = $first === $this->getCurrentStep() ? $first : prev($this->steps);

        return $step;
    }

    public function setStep(int $step = 0): Step
    {
        reset($this->steps);

        while ($this->getCurrentStep()->id < $step) {
            $this->getNextStep();
        }

        return $this->getCurrentStep();
    }

    public function setSleep($time)
    {
        usleep(\PHPUNIT_TEST_IS_RUNNING ? 0 : $time);
    }

    abstract public function dispatchInput();
}