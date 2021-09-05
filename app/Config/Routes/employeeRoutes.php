<?php

use App\Controllers\EmployeeController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  $app->get('/funcionario', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write(EmployeeController::getDashboard());
    return $response;
  });

  $app->get('/funcionario/professores', function (ServerRequestInterface $request, ResponseInterface $response) {
    $start = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;

    $response->getBody()->write(EmployeeController::getTeachers($start, $size));
    return $response;
  });

  $app->get('/funcionario/professor/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write(EmployeeController::getAddTeacher());
    return $response;
  });

  $app->post('/funcionario/professor/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
    EmployeeController::setAddTeacher($request->getParsedBody());
    return $response;
  });

  $app->get('/funcionario/professor/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $id = $args['id'];

    $response->getBody()->write(EmployeeController::getTeacher($id));
    return $response;
  });

  $app->get('/funcionario/listar', function (ServerRequestInterface $request, ResponseInterface $response) {
    $start = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;

    $response->getBody()->write(EmployeeController::getEmployees($start, $size));
    return $response;
  });

  $app->get('/funcionario/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $response->getBody()->write(EmployeeController::getAddEmployee());
    return $response;
  });

  $app->post('/funcionario/adicionar', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    EmployeeController::setAddEmployee($request->getParsedBody());
    return $response;
  });

  $app->get('/funcionario/alunos', function (ServerRequestInterface $request, ResponseInterface $response) {
    $start = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;

    $response->getBody()->write(EmployeeController::getStudents($start, $size));
    return $response;
  });

  $app->get('/funcionario/aluno/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write(EmployeeController::getAddStudent());
    return $response;
  });

  $app->post('/funcionario/aluno/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
    EmployeeController::setAddStudent($request->getParsedBody());
    return $response;
  });

  $app->get('/funcionario/aluno/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $id = $args['id'];

    $response->getBody()->write(EmployeeController::getStudent($id));
    return $response;
  });

  $app->get('/funcionario/turmas', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $start = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;

    $response->getBody()->write(EmployeeController::getClasses($start, $size));
    return $response;
  });

  $app->get('/funcionario/turma/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write(EmployeeController::getAddClass());
    return $response;
  });

  $app->post('/funcionario/turma/adicionar', function (ServerRequestInterface $request, ResponseInterface $response) {
    EmployeeController::setAddClass($request->getParsedBody());
    return $response;
  });

  $app->get('/funcionario/turma/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $id = $args['id'];

    $response->getBody()->write(EmployeeController::getClass($id));
    return $response;
  });

  $app->get('/funcionario/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $id = $args['id'];

    $response->getBody()->write(EmployeeController::getEmployee($id));
    return $response;
  });
};