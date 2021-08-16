<?php

use App\Http\Middlewares\Queue as MiddlewareQueue;
use App\Http\Router;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

define('URL', $_ENV['URL']);
define('DBHOST', $_ENV['DBHOST']);
define('DBDATABASE', $_ENV['DBDATABASE']);
define('DBUSER', $_ENV['DBUSER']);
define('DBPASS', $_ENV['DBPASS']);

$router = new Router(URL);

MiddlewareQueue::setMap([
  'requiredTeacherLogin' => \App\Http\Middlewares\RequiredTeacherLogin::class,
  'requiredLogout' => \App\Http\Middlewares\RequiredLogout::class
]);

include __DIR__ . '/routes/external.php';
include __DIR__ . '/routes/teachers.php';

$router->run()->sendResponse();
