<?php

date_default_timezone_set('America/Sao_Paulo');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization');
header('Accept: application/json');

require realpath(__DIR__) . '/vendor/autoload.php';

define('APP_ENVIRONMENT', parse_ini_file(\Cadtreesa\classes\Cfg::FILE, true));

require realpath(__DIR__) . '/src/routes/web.php';

ob_start("ob_gzhandler");

echo $route->dispatch()->response();

ob_end_flush();