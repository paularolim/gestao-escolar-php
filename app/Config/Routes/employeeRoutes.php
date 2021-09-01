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

  $app->get('/funcionario/professor/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $id = $args['id'];

    $response->getBody()->write(EmployeeController::getTeacher($id));
    return $response;
  });

  $app->get('/funcionario/listar', function (ServerRequestInterface $request, ResponseInterface $response) {
    $start = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 5;

    $response->getBody()->write(EmployeeController::getEmployees($start, $size));
    return $response;
  });

  $app->get('/funcionario/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $id = $args['id'];

    $response->getBody()->write(EmployeeController::getEmployee($id));
    return $response;
  });
};
