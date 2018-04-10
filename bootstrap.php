<?php

date_default_timezone_set('America/Sao_Paulo');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, Access-Control-Request-Headers');
header('Accept: application/json');

// The request was accepted but waits for a new request method: POST, PUT, DELETE or GET
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header ('HTTP/1.1 202 Accepted');
	die();
}

require realpath(__DIR__) . '/vendor/autoload.php';

define('APP_ENVIRONMENT', parse_ini_file(\Cadtreesa\classes\Cfg::FILE, true));

require realpath(__DIR__) . '/src/routes/web.php';

ob_start("ob_gzhandler");

echo $route->dispatch()->response();

ob_end_flush();