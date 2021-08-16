<?php

use App\Controllers\TeachersController;
use App\Http\Request;
use App\Http\Response;

$router->post('/professores/login', [
  function (Request $request) {
    return new Response(TeachersController::setLogin($request));
  }
]);

$router->get('/professores/logout', [
  function (Request $request) {
    return new Response(TeachersController::setLogout($request));
  }
]);

$router->get('/professores', [
  'middlewares' => [
    'requiredTeacherLogin'
  ],
  function () {
    return new Response(TeachersController::getDashboard());
  }
]);
