<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Dotenv\Dotenv;
use Zalo\Zalo;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

$config = array(
    'app_id' => $_ENV['APP_ID'],
    'app_secret' => $_ENV['SECRET_KEY']
);
$zalo = new Zalo($config);

$kernel = new Kernel($_ENV['APP_ENV'], (bool)$_ENV['APP_DEBUG']);
$request = Request::createFromGlobals();;

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

