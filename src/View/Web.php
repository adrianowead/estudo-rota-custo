<?php

namespace Wead\View;

use Wead\Controller\Flow;

final class Web extends Flow
{
    private $src;

    public function __construct()
    {
        $this->src = getcwd() . "/public/";
    }

    public function render()
    {
        echo file_get_contents($this->src . "index.html");
    }

    public function dispatchInput()
    {
    }

    public function checkTripPossible()
    {
    }
}
