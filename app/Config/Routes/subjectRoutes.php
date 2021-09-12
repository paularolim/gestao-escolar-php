<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\SubjectController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/materias', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response) {
      $page = $request->getQueryParams()['page'] ?? 1;
      $size = $request->getQueryParams()['size'] ?? 20;

      $response->getBody()->write(SubjectController::getSubjects($page, $size));
      return $response;
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(SubjectController::getAddSubject());
      return $response;
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(SubjectController::setAddSubject($request->getParsedBody()));
      return $response;
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $id = $args['id'];

      $response->getBody()->write(SubjectController::getSubject($id));
      return $response;
    });
  })->add(new RequiredLoginMiddleware());
};
