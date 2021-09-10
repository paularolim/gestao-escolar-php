<?php

use App\Controllers\EmployeeSubjectController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/funcionario', function (RouteCollectorProxy $group) {

    $group->get('/materias', function (ServerRequestInterface $request, ResponseInterface $response) {
      $page = $request->getQueryParams()['page'] ?? 1;
      $size = $request->getQueryParams()['size'] ?? 20;

      $response->getBody()->write(EmployeeSubjectController::getSubjects($page, $size));
      return $response;
    });

    $group->get('/materia/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(EmployeeSubjectController::getAddSubject());
      return $response;
    });

    $group->post('/materia/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(EmployeeSubjectController::setAddSubject($request->getParsedBody()));
      return $response;
    });

    $group->get('/materia/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $id = $args['id'];

      $response->getBody()->write(EmployeeSubjectController::getSubject($id));
      return $response;
    });
  });
};
