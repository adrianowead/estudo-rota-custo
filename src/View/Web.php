<?php

namespace Wead\View;

use Wead\Controller\Flow;
use Wead\Http\Request;

final class Web extends Flow
{
    private $src;
    private $defaultParams = [
        'title' => 'Asa Quebrada'
    ];

    public function __construct()
    {
        $this->src = getcwd() . "/templates/";
    }

    public function welcomeAction(Request $request): string
    {
        return $this->render('welcome', [
            'message' => "Asa Quebrada AirLines!"
        ]);
    }

    public function ajaxAction(Request $request): string
    {
        return $this->render('ajax');
    }

    public function socketAction(Request $request): string
    {
        return $this->render('socket');
    }

    public function render(string $view, array $params = []): string
    {
        $params = array_merge($this->defaultParams, $params);

        $html  = file_get_contents($this->src . "header.html");
        $html .= file_get_contents($this->src . "{$view}.html");
        $html .= file_get_contents($this->src . "footer.html");

        foreach ($params as $k => $v) {
            $html = str_replace("%{$k}%", $v, $html);
        }

        return $html;
    }

    public function dispatchInput()
    {
    }

    public function checkTripPossible()
    {
    }
}