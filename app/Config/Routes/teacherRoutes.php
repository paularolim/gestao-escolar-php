<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\TeacherController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/professores', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response) {
      $page = $request->getQueryParams()['page'] ?? 1;
      $size = $request->getQueryParams()['size'] ?? 20;

      $response->getBody()->write(TeacherController::getTeachers($page, $size));
      return $response;
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(TeacherController::getAddTeacher());
      return $response;
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(TeacherController::setAddTeacher($request->getParsedBody()));
      return $response;
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $id = $args['id'];

      $response->getBody()->write(TeacherController::getTeacher($id));
      return $response;
    });
  })->add(new RequiredLoginMiddleware());
};
