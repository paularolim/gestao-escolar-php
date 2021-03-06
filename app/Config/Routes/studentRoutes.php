<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\StudentController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/alunos', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response) {
      $page = $request->getQueryParams()['page'] ?? 1;
      $size = $request->getQueryParams()['size'] ?? 20;

      $response->getBody()->write(StudentController::getStudents($page, $size));
      return $response;
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $response->getBody()->write(StudentController::getAddStudent());
      return $response;
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      StudentController::setAddStudent($request->getParsedBody());
      return $response;
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $id = $args['id'];

      $response->getBody()->write(StudentController::getStudent($id));
      return $response;
    });
  })->add(new RequiredLoginMiddleware());
};
