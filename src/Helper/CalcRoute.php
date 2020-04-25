<?php

namespace Wead\Helper;

trait CalcRoute
{
    private $from;
    private $to;

    private function routeAssemble()
    {
        return chr(13) . chr(10) . "GRU -> POA -> CXJ";
    }

    private function tripType()
    {
        return "com escala";
    }

    private function performCalc()
    {
        return "R$ 15,00";
    }
}
