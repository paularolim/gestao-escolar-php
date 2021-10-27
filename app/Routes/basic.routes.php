<?php

use App\Controllers\LoginController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    return LoginController::getLoginScreen($request, $response);
  });

  $app->post('/', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    return LoginController::setLogin($request, $response);
  });
};
