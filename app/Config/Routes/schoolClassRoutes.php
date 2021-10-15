<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\SchoolClassController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/turmas', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response) {
      $page = $request->getQueryParams()['page'] ?? 1;
      $size = $request->getQueryParams()['size'] ?? 20;

      $response->getBody()->write(SchoolClassController::getSchoolClasses($page, $size));
      return $response;
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(SchoolClassController::getAddSchoolClass());
      return $response;
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
      $response->getBody()->write(SchoolClassController::setAddSchoolClass($request->getParsedBody()));
      return $response;
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return SchoolClassController::getSchoolClass($request, $response, $args);
    });
  })->add(new RequiredLoginMiddleware());
};
