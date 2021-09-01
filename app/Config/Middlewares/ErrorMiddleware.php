<?php

use App\Config\Errors\NotFoundError;
use Slim\App;

return function(App $app) {
  $app->addRoutingMiddleware();
  $errorMiddleware = $app->addErrorMiddleware(true, true, true);
  $errorHandler = (object) $errorMiddleware->getDefaultErrorHandler();
  $errorHandler->registerErrorRenderer('text/html', NotFoundError::class);
};