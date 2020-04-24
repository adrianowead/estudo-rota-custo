<?php

namespace Wead;

use Wead\View\Cli;

final class Boostrap
{
    public function run(): void
    {
        $f = new Cli;
        $f->dispatchInput();
    }
}