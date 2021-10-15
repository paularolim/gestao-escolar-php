<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\ScheduleController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/horarios', function (RouteCollectorProxy $group) {
    $group->get('', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
      return ScheduleController::getSchedulesFromUser($request, $response);
    });

    $group->get('/adicionar/{idClass}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return ScheduleController::getAddSchedule($request, $response, $args);
    });

    $group->post('/adicionar/{idClass}', function (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
      return ScheduleController::setAddSchedule($request, $response, $args);
    });
  })->add(new RequiredLoginMiddleware());
};
