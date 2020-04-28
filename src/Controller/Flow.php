<?php

namespace Wead\Controller;

use Wead\Controller\dto\Step;

abstract class Flow
{
    private $steps;
    public $config;
    public $inputs = [];

    public function __construct()
    {
        $data = new Steps();

        $this->steps = $data->steps;
        $this->config = $data->getConfig();
    }

    public function getCurrentStep(): Step
    {
        return $this->steps->current();
    }

    public function getNextStep(): Step
    {
        $this->steps->next();
        return $this->getCurrentStep();
    }

    public function getPreviusStep(): Step
    {
        $key = $this->steps->key();
        $this->steps->rewind();

        while ($key != $this->steps->key()) {
            $this->steps->next();
        }

        return $this->getCurrentStep();
    }

    public function setStep(int $step = 0): Step
    {
        $this->steps->rewind();

        do {
            $this->steps->next();
        } while ($step != $this->steps->key());

        return $this->getCurrentStep();
    }

    public function setSleep($time)
    {
        usleep(\PHPUNIT_TEST_IS_RUNNING ? 0 : $time);
    }

    public function replaceVars($string)
    {
        if (sizeof($this->inputs) > 0) {
            $string = str_replace(
                array_keys($this->inputs),
                $this->inputs,
                $string
            );
        }

        return $string;
    }

    public function cleanUpStepMessage(Step $step): Step
    {
        $step->text = preg_replace('/\|.*?\|/', '', $step->text);

        return $step;
    }

    abstract public function checkTripPossible();
}
