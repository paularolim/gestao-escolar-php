<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once(__DIR__ . '/vendor/autoload.php');

$app = AppFactory::create();
$twig = Twig::create(__DIR__ . '/app/Views', ['cache' => false]);

// config
require_once(__DIR__ . '/app/Config/Constants.php');

// middlewares
$app->add(TwigMiddleware::create($app, $twig));

// routes
(require_once('./app/Routes/index.routes.php'))($app);

$app->run();
