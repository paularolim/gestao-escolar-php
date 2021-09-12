<?php

use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

define('URL', $_ENV['URL']);
define('DBHOST', $_ENV['DBHOST']);
define('DBDATABASE', $_ENV['DBDATABASE']);
define('DBUSER', $_ENV['DBUSER']);
define('DBPASS', $_ENV['DBPASS']);

$app = AppFactory::create();

// middlewares
(require('./app/Config/Middlewares/ErrorMiddleware.php'))($app);

// routes
(require './app/Config/Routes/basicRoutes.php')($app);
(require './app/Config/Routes/employeeRoutes.php')($app);
// (require('./app/Config/Routes/employeeSubjectsRoutes.php'))($app);

$app->run();