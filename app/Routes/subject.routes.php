<?php

use App\Middlewares\RequiredLoginMiddleware;
use App\Controllers\SubjectController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/materias', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return SubjectController::getAll($request, $response);
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return SubjectController::getAdd($request, $response);
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return SubjectController::setAdd($request, $response);
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return SubjectController::getOne($request, $response, $args);
    });
  })->add(new RequiredLoginMiddleware());
};
