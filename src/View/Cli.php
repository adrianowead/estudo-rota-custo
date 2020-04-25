<?php

namespace Wead\View;

use Wead\Controller\Flow;

final class Cli extends Flow
{
    private $timeWriteLetter = 20000;
    private $inputs = [];

    public function dispatchInput()
    {
        $step = $this->getCurrentStep();

        while ($step->next) {
            $this->performText($step->text);

            if ($step->required) {
                $this->inputs[$step->namespace] = $this->catchInput();
            }

            if ($step->wait && $step->wait > 0) {
                usleep($step->wait * 1000000);
            }

            $step = $this->getNextStep();
        }
    }

    private function persistAsk()
    {
        $this->performText($this->config->defaultError);

        usleep($this->config->timeWait * 1000000);
        $this->performText($this->getCurrentStep()->text);

        return $this->catchInput();
    }

    private function catchInput()
    {
        if (PHP_OS == 'WINNT') {
            echo "> ";
            $line = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            $line = readline("> ");
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

        echo chr(13) . chr(10);

        foreach ($parts as $v) {
            if (is_numeric($v)) {
                sleep($v);
            } else {
                $this->typeCli($v);
            }
        }

        echo chr(13) . chr(10);
    }

    private function replaceVars($string)
    {
        if(sizeof($this->inputs) > 0){
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
            usleep($this->timeWriteLetter);
        }
    }
}