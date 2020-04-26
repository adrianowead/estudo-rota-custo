<?php

namespace Wead;

use Wead\View\Cli;
use Wead\View\Web;
use Wead\Http\Router;
use Wead\Http\Request;

final class Boostrap
{
    public function run($sapi): void
    {
        if (\PHPUNIT_TEST_IS_RUNNING) {
            ob_start();
        }

        if ($sapi === 'cli') {
            $f = new Cli();
            $f->dispatchInput();
        } else {
            $this->listenRoutes();
        }

        if (\PHPUNIT_TEST_IS_RUNNING) {
            ob_get_clean();
        }
    }

    public function listenRoutes()
    {
        $http = new Router(new Request);
        $web = new Web;

        $http->get('/', function (Request $request) use ($web) {
            return $web->welcomeAction($request);
        });

        $http->get('/ajax', function (Request $request) use ($web) {
            return $web->ajaxAction($request);
        });

        $http->get('/socket', function (Request $request) use ($web) {
            return $web->socketAction($request);
        });
    }
}