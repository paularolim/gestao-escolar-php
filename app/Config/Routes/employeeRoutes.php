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

  $app->get('/funcionario/professores', function (ServerRequestInterface $request, ResponseInterface $response) {
    $start = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 5;

    $response->getBody()->write(EmployeeController::getTeachers($start, $size));
    return $response;
  });
};
