<?php

namespace Wead\View;

use Wead\Http\Request;
use Wead\Model\Routes;
use Wead\Helper\CalcRoute;
use Wead\Controller\dto\Route;
use Wead\Helper\ExtractStarWars;

final class Api
{
    use CalcRoute;

    public function quoteAction(Request $request): string
    {
        $this->from = $request->getBody()['from'];
        $this->to = $request->getBody()['to'];

        return json_encode([
            "route" => implode(",", $this->routeAssemble()),
            "price" => $this->getTotalValue(false)
        ]);
    }

    public function newRouteAction(Request $request): void
    {
        $data = $_POST;

        foreach ($data as $k => $v) {
            $data[$k] = trim($v);
        }

        if (isset($data['from']) && isset($data['to']) && isset($data['price'])) {
            if (strlen($data['from']) > 0 && strlen($data['to']) > 0 && strlen($data['price']) > 0) {
                $model = new Routes();
                $model->insert(new Route((object) array_values($data)));
            }
        }
    }

    public function getFilmAction(Request $request): string
    {
        return ExtractStarWars::getContent();
    }
}
