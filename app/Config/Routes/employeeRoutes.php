<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\EmployeeController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/funcionarios', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return EmployeeController::getEmployees($request, $response);
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return EmployeeController::getAddEmployee($request, $response);
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      EmployeeController::setAddEmployee($request->getParsedBody());
      return $response;
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      $id = $args['id'];

      $response->getBody()->write(EmployeeController::getEmployee($id));
      return $response;
    });
  })->add(new RequiredLoginMiddleware());
};
