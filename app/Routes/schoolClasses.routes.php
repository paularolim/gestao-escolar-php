<?php

use App\Middlewares\RequiredLoginMiddleware;
use App\Controllers\SchoolClassController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/turmas', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return SchoolClassController::getAll($request, $response);
    });

    $group->get('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return SchoolClassController::getAdd($request, $response);
    });

    $group->post('/adicionar', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return SchoolClassController::setAdd($request, $response);
    });

    $group->get('/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return SchoolClassController::getOne($request, $response, $args);
    });

    $group->get('/{id}/horarios/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return SchoolClassController::getAddSchedule($request, $response, $args);
    });

    $group->post('/{id}/horarios/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return SchoolClassController::setAddSchedule($request, $response, $args);
    });
  })->add(new RequiredLoginMiddleware());
};
