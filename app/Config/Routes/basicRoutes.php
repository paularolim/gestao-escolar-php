<?php

use App\Config\Middlewares\RequiredLoginMiddleware;
use App\Config\Middlewares\RequiredLogoutMiddleware;

use App\Controllers\LoginController;
use App\Controllers\DashboardController;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write(LoginController::getLogin());
    return $response;
  })->add(new RequiredLogoutMiddleware);

  $app->post('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $body = $request->getParsedBody();
    $profile = $body['profile'];
    $document = $body['document'];
    $password = $body['password'];

    $response->getBody()->write(LoginController::setLogin($profile, $document, $password));

    return $response;
  });

  $app->get('/logout', function () {
    LoginController::logout();
  });

  $app->get('/dashboard', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write(DashboardController::getDashboard());
    return $response;
  })->add(new RequiredLoginMiddleware);
};
