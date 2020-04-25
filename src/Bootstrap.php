<?php

namespace Wead;

use Wead\View\Cli;

final class Boostrap
{
    public function run($sapi): void
    {
        if ($sapi === 'cli') {
            $f = new Cli;

            if (!PHPUNIT_TEST_IS_RUNNING) {
                $f->dispatchInput();
            } else {
                ob_start();
                $f->dispatchInput();
                ob_get_clean();
            }
        }
    }
}