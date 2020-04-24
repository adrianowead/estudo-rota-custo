<?php

namespace Wead\View;

use Wead\Controller\Flow;

final class Cli extends Flow
{
    public function dispatchInput()
    {
        $step = $this->getCurrentStep();

        $this->performText($step->text);
    }

    private function catchInput()
    {
        if (PHP_OS == 'WINNT') {
            echo "> ";
            $line = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            $line = readline("> ");
        }

        return $line;
    }

    private function performText()
    {
        //
    }
}