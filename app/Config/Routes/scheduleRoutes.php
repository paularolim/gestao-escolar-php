<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Controllers\ScheduleController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->group('/horarios', function (RouteCollectorProxy $group) {
    $group->get('/adicionar/{idClass}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $idClass = $args['idClass'];

      $response->getBody()->write(ScheduleController::getAddSchedule($idClass));
      return $response;
    });

    $group->post('/adicionar/{idClass}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $idClass = $args['idClass'];

      $response->getBody()->write(ScheduleController::setAddSchedule($idClass, $request->getParsedBody()));
      return $response;
    });

    $group->get('/{idClass}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
      $idClass = $args['idClass'];

      $response->getBody()->write(ScheduleController::getSchedules($idClass));
      return $response;
    });
  })->add(new RequiredLoginMiddleware());
};
