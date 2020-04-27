<?php

namespace Wead\Http;

use Wead\Http\IRequest;

final class Router
{
    private $request;

    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    public function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    public function __call($name, $args)
    {
        list($route, $method) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
        exit;
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
        exit;
    }

    private function invalidUriParamsHandler()
    {
        header("{$this->request->serverProtocol} 418 I'm a teapot, incorrect params");
        exit;
    }

    /**
     * Resolves a route
     */
    private function resolve()
    {
        if (!property_exists($this, strtolower($this->request->requestMethod))) {
            $this->invalidMethodHandler();
        }

        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);

        $this->extractParams($methodDictionary, $formatedRoute);

        if (!isset($methodDictionary[$formatedRoute])) {
            $this->invalidUriParamsHandler();
        }

        $method = $methodDictionary[$formatedRoute];

        if (is_null($method)) {
            $this->defaultRequestHandler();
            return;
        }

        echo call_user_func_array($method, array($this->request));
    }

    private function extractParams(array &$dictionary, string &$uri): void
    {
        $params = preg_split('/(\/+)/', $uri);
        array_shift($params);

        foreach ($dictionary as $route => $v) {
            $fields = preg_split('/(\/+)/', $route);
            array_shift($fields);

            if (sizeof($fields) > 1) {
                $dictionary["/{$fields[0]}"] = $dictionary[$route];
                unset($dictionary[$route]);

                if ($params[0] == $fields[0]) {
                    $uri = "/{$fields[0]}";

                    array_shift($params);
                    array_shift($fields);

                    if (sizeof($params) != sizeof($fields)) {
                        $this->invalidUriParamsHandler();
                    }

                    foreach ($fields as $k => $field) {
                        $field = preg_replace('/[^0-9A-Za-z]/', '', $field);
                        $_GET[$field] = $params[$k];
                    }
                }
            }
        }
    }

    function __destruct()
    {
        $this->resolve();
    }
}
