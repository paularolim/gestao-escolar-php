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
  'middlewares' => [
    'requiredEmployeeLogin'
  ],
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

$router->get('/funcionarios/professores', [
  'middlewares' => [
    'requiredEmployeeLogin'
  ],
  function () {
    return new Response(EmployeesController::getTeachers());
  }
]);

$router->get('/funcionarios/professores/adicionar', [
  'middlewares' => [
    'requiredEmployeeLogin'
  ],
  function () {
    return new Response(EmployeesController::getAddTeacher());
  }
]);

$router->post('/funcionarios/professores/adicionar', [
  'middlewares' => [
    'requiredEmployeeLogin'
  ],
  function (Request $request) {
    return new Response(EmployeesController::setAddTeacher($request));
  }
]);
