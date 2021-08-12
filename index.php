<?php

use App\Http\Router;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$router = new Router($_ENV['URL']);

include __DIR__ . '/routes/external.php';
include __DIR__ . '/routes/teachers.php';

$router->run()->sendResponse();
