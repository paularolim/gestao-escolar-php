<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// middlewares
(require('./app/Config/Middlewares/ErrorMiddleware.php'))($app);

// routes
(require('./app/Config/Routes/employeeRoutes.php'))($app);

$app->run();