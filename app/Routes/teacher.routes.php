<?php

use App\Middlewares\RequiredLoginMiddleware;
use App\Controllers\TeacherController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/professores', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return TeacherController::getTeachers($request, $response);
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return TeacherController::getAddTeacher($request, $response);
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return TeacherController::setAddTeacher($request, $response);
    });

    $group->post('/{id}/materias/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return TeacherController::setAddSubject($request, $response, $args);
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return TeacherController::getTeacher($request, $response, $args);
    });
  })->add(new RequiredLoginMiddleware());
};
