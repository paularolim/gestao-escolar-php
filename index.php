<?php

use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

define('URL', $_ENV['URL']);
define('DBHOST', $_ENV['DBHOST']);
define('DBDATABASE', $_ENV['DBDATABASE']);
define('DBUSER', $_ENV['DBUSER']);
define('DBPASS', $_ENV['DBPASS']);

$app = AppFactory::create();
$twig = Twig::create('app/Views', ['cache' => false]);

// middlewares
$app->add(TwigMiddleware::create($app, $twig));
(require('./app/Config/Middlewares/ErrorMiddleware.php'))($app);

// routes
(require './app/Config/Routes/basicRoutes.php')($app);
(require './app/Config/Routes/employeeRoutes.php')($app);
(require './app/Config/Routes/teacherRoutes.php')($app);
(require './app/Config/Routes/studentRoutes.php')($app);
(require './app/Config/Routes/subjectRoutes.php')($app);
(require './app/Config/Routes/schoolClassRoutes.php')($app);
(require './app/Config/Routes/scheduleRoutes.php')($app);

$app->run();
