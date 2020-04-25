<?php

define('PHPUNIT_TEST_IS_RUNNING', false);

require_once __DIR__ . "/vendor/autoload.php";

$run = new Wead\Boostrap;
$run->run(php_sapi_name());