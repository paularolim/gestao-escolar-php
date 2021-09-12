<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\EmployeeController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/funcionarios', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response) {
      $page = $request->getQueryParams()['page'] ?? 1;
      $size = $request->getQueryParams()['size'] ?? 20;

      $response->getBody()->write(EmployeeController::getEmployees($page, $size));
      return $response;
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $response->getBody()->write(EmployeeController::getAddEmployee());
      return $response;
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      EmployeeController::setAddEmployee($request->getParsedBody());
      return $response;
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $id = $args['id'];

      $response->getBody()->write(EmployeeController::getEmployee($id));
      return $response;
    });
  })->add(new RequiredLoginMiddleware());
};
