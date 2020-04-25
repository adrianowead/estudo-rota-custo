<?php

namespace Wead;

use Wead\View\Cli;
use Wead\View\Web;

final class Boostrap
{
    public function run($sapi): void
    {
        if ($sapi === 'cli') {
            $f = new Cli();

            if (!PHPUNIT_TEST_IS_RUNNING) {
                $f->dispatchInput();
            } else {
                ob_start();
                $f->dispatchInput();
                ob_get_clean();
            }
        } elseif ($sapi == "cli-server") {
            $f = new Web();
            $f->render();
        }
    }
}
