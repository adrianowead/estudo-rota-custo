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
            $f->dispatchInput();
        } else {
            $f = new Web();
            $f->render();
        }
    }
}
