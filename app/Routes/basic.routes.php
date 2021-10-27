<?php

use App\Middlewares\RequiredLoginMiddleware;
use App\Controllers\DashboardController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Middlewares\RequiredLogoutMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    return LoginController::getLoginScreen($request, $response);
  })->add(new RequiredLogoutMiddleware());

  $app->post('/', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    return LoginController::setLogin($request, $response);
  })->add(new RequiredLogoutMiddleware());

  $app->get('/dashboard', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    return DashboardController::getDashboardScreen($request, $response);
  })->add(new RequiredLoginMiddleware());

  $app->get('/logout', function (): void {
    LogoutController::setLogout();
  })->add(new RequiredLoginMiddleware());
};
