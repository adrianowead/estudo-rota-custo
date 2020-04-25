<?php

namespace Wead\View;

use Wead\Helper\CalcRoute;
use Wead\Controller\Flow;

final class Cli extends Flow
{
    use CalcRoute;

    private $timeWriteLetter = 20000;
    private $inputs = [];

    public function dispatchInput()
    {
        $step = $this->getCurrentStep();

        while ($step->next) {
            $this->watchParams();

            $this->performText($step->text);

            if ($step->required) {
                $this->inputs[$step->namespace] = $this->catchInput();
            }

            if ($step->wait && $step->wait > 0) {
                $this->setSleep($step->wait * 1000000);
            }

            $step = $this->getNextStep();
        }
    }

    private function watchParams()
    {
        // monitorando quando os inputs chaves forem preenchidos
        if (isset($this->inputs['%pontoOrigem%']) && isset($this->inputs['%pontoDestino%'])) {
            $this->from = $this->inputs['%pontoOrigem%'];
        }

        if (isset($this->inputs['%pontoDestino%'])) {
            $this->to = $this->inputs['%pontoDestino%'];
        }

        $this->inputs['%checkPoints%'] = $this->routeAssemble();
        $this->inputs['%tipoDeViajem%'] = $this->tripType();
        $this->inputs['%valorTotal%'] = $this->performCalc();
    }

    private function persistAsk()
    {
        $this->performText($this->config->defaultError);

        $this->setSleep($this->config->timeWait * 1000000);

        $this->performText($this->getCurrentStep()->text);

        return $this->catchInput();
    }

    private function catchInput()
    {
        if (PHP_OS == 'WINNT') {
            echo "> ";
            $line = \PHPUNIT_TEST_IS_RUNNING ? 'test' : trim(stream_get_line(STDIN, 1024, PHP_EOL));
        } else {
            $line = \PHPUNIT_TEST_IS_RUNNING ? 'test' : trim(readline("> "));
        }

        $line = trim($line);

        if (strlen($line) == 0) {
            return $this->persistAsk();
        }

        return $line;
    }

    private function performText($string)
    {
        $string = $this->replaceVars($string);

        $parts = preg_split('/[\|]+/', $string);

        foreach ($parts as $v) {
            if (is_numeric($v)) {
                $this->setSleep($v * 1000000);
            } else {
                $this->typeCli($v);
            }
        }

        echo chr(13) . chr(10);
    }

    private function replaceVars($string)
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

    private function typeCli($text)
    {
        for ($y = 0; $y < strlen($text); $y++) {
            echo $text[$y];
            $this->setSleep($this->timeWriteLetter);
        }
    }
}