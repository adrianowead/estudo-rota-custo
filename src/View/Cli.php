<?php

namespace Wead\View;

use Wead\Helper\CalcRoute;
use Wead\Controller\Flow;

final class Cli extends Flow
{
    use CalcRoute;

    private $timeWriteLetter = 20000;

    public function dispatchInput()
    {
        $step = $this->getCurrentStep();

        while ($step->next) {
            $this->watchParams();

            $step = $this->getCurrentStep();

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
            $this->to = $this->inputs['%pontoDestino%'];

            $this->inputs['%checkPoints%'] = chr(13) . chr(10) . implode(" -> ", $this->routeAssemble());
            $this->inputs['%tipoDeViajem%'] = $this->tripType();
            $this->inputs['%valorTotal%'] = $this->getTotalValue();

            $this->checkTripPossible();
        }
    }

    public function checkTripPossible()
    {
        if (!$this->allMatch || sizeof($this->allMatch) == 0) {
            $this->performText($this->config->routeNotFound);

            $this->setSleep($this->config->timeWait * 1000000);

            if (!\PHPUNIT_TEST_IS_RUNNING) {
                $this->setStep(7);
            }

            unset($this->inputs['%pontoOrigem%']);
            unset($this->inputs['%pontoDestino%']);
        }
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
            $line = \PHPUNIT_TEST_IS_RUNNING ? 'GRU' : trim(stream_get_line(STDIN, 1024, PHP_EOL));
        } else {
            $line = \PHPUNIT_TEST_IS_RUNNING ? 'GRU' : trim(readline("> "));
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

    private function typeCli($text)
    {
        for ($y = 0; $y < strlen($text); $y++) {
            echo $text[$y];
            $this->setSleep($this->timeWriteLetter);
        }
    }
}
