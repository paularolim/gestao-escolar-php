<?php

use App\Controllers\EmployeeController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  $app->get('/funcionario', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write(EmployeeController::getDashboard());
    return $response;
  });
};
