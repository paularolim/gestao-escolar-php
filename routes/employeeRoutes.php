<?php

use App\Controllers\EmployeesController;
use App\Http\Request;
use App\Http\Response;

$router->post('/funcionarios/login', [
  function (Request $request) {
    return new Response(EmployeesController::setLogin($request));
  }
]);

$router->get('/funcionarios/logout', [
  function (Request $request) {
    return new Response(EmployeesController::setLogout($request));
  }
]);

$router->get('/funcionarios', [
  'middlewares' => [
    'requiredEmployeeLogin'
  ],
  function () {
    return new Response(EmployeesController::getDashboard());
  }
]);
