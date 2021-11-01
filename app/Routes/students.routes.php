<?php

use App\Middlewares\RequiredLoginMiddleware;
use App\Controllers\StudentController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/alunos', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return StudentController::getStudents($request, $response);
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return StudentController::getAddStudent($request, $response);
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return StudentController::setAddStudent($request, $response);
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return StudentController::getStudent($request, $response, $args);
    });

    $group->post('/{id}/turmas', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return StudentController::setAddSchoolClass($request, $response, $args);
    });
  })->add(new RequiredLoginMiddleware());
};
