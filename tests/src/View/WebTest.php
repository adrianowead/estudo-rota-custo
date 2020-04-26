<?php

namespace Wead\Test\View;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use Wead\Http\Request;
use Wead\View\Web;

class WebTest extends TestCase
{
    private $http;
    private static $process;

    public static function setUpBeforeClass(): void
    {
        self::$process = new Process([
            PHP_BINARY,
            '-S', 'localhost:9090',
        ]);
        self::$process->start();

        usleep(1000000); //wait for server to get going
    }

    public function setUp(): void
    {
        $this->http = new Client([
            'base_uri'    => 'http://localhost:9090',
            'http_errors' => false,
        ]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public static function tearDownAfterClass(): void
    {
        self::$process->stop();
    }

    public function testDispatchInput()
    {
        $web = new Web();

        $this->assertNull($web->dispatchInput());
    }

    public function testCheckTripPossible()
    {
        $web = new Web();

        $this->assertNull($web->checkTripPossible());
    }

    public function testRender()
    {
        $web = new Web();

        ob_start();
        $web->render('welcome');
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }

    public function testWelcomeAction()
    {
        $web = new Web();

        ob_start();
        $web->welcomeAction(new Request);
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }

    public function testAjaxAction()
    {
        $web = new Web();

        ob_start();
        $web->ajaxAction(new Request);
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }

    public function testSocketAction()
    {
        $web = new Web();

        ob_start();
        $web->socketAction(new Request);
        $out = ob_get_clean();

        $this->assertNotNull($out);
    }

    public function testWelcomeActionHttp()
    {
        $response = $this->http->get('/');

        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getBody(true);
        $this->assertStringContainsString('html', $data);
    }

    public function testAjaxActionHttp()
    {
        $response = $this->http->get('/ajax');

        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getBody(true);
        $this->assertStringContainsString('html', $data);
    }

    public function testSocketActionHttp()
    {
        $response = $this->http->get('/socket');

        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getBody(true);
        $this->assertStringContainsString('html', $data);
    }
}