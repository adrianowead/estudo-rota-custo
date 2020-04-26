<?php

namespace Wead\Test\View;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use Wead\Http\Request;
use Wead\View\Api;

class ApiTest extends TestCase
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

    public function testQuoteAction()
    {
        $_GET['from'] = "GRU";
        $_GET['to'] = "SCL";

        $api = new Api();
        $out = $api->quoteApiAction(new Request());

        @json_encode($out);

        $this->assertTrue((json_last_error() === JSON_ERROR_NONE));
        $this->assertStringContainsString('GRU', $out);
        $this->assertStringContainsString('SCL', $out);
    }

    public function testQuoteApiActionHttp()
    {
        $response = $this->http->get('/quote/GRU/SCL');

        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getBody(true);

        @json_encode($data);

        $this->assertTrue((json_last_error() === JSON_ERROR_NONE));
        $this->assertStringContainsString('GRU', $data);
        $this->assertStringContainsString('SCL', $data);
    }
}
