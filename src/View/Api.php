<?php

namespace Wead\View;

use Wead\Helper\CalcRoute;
use Wead\Http\Request;

final class Api
{
    use CalcRoute;

    public function quoteApiAction(Request $request): string
    {
        $this->from = $request->getBody()['from'];
        $this->to = $request->getBody()['to'];

        return json_encode([
            "route" => implode(",", $this->routeAssemble()),
            "price" => $this->getTotalValue(false)
        ]);
    }
}
