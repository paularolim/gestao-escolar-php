<?php

use App\Http\Router;

require __DIR__ . '/vendor/autoload.php';

define('URL', 'http://localhost:8000');

$router = new Router(URL);

include __DIR__ . '/routes/external.php';
include __DIR__ . '/routes/teachers.php';

$router->run()->sendResponse();
