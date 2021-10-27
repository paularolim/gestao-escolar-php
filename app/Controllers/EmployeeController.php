<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\Session;
use App\Models\Employee;
use App\Utils\Pagination;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class EmployeeController
{
  public static function getEmployees(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $page = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $total = Employee::getCount();
      $pagination = new Pagination($page, $size, $total);
      $pages = $pagination->getInfo();
      $employees = Employee::getAll(['id', 'name', 'document'], null, 'name ASC', $pagination->limit());

      return $view->render($response, 'Employee/list.html', [
        'user' => Session::getUser(),
        'employees' => $employees,
        'total' => $total,
        'pages' => $pages
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => Session::getUser()
    ]);
  }

  public static function getEmployee(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $employeeId = $params['id'];

    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      $employee = Employee::getById($employeeId, ['name', 'document', 'email', 'dateOfBirth']);

      return $view->render($response, 'Employee/details.html', [
        'user' => $user,
        'employee' => $employee
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function getAddEmployee(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      return $view->render($response, 'Employee/add.html', [
        'user' => $user
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function setAddEmployee(ServerRequestInterface $request, ResponseInterface $response)
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    $body = $request->getParsedBody();

    $employee = new Employee();
    $employee->setName($body['name']);
    $employee->setDateOfBirth($body['dateOfBirth']);
    $employee->setDocument($body['document']);
    $employee->setEmail($body['email']);
    $employee->setRole($body['role']);

    try {
      $employee->store();
      header('Location: /funcionarios');
      exit;
    } catch (Error $e) {
      die($e);
      return $view->render($response, 'Employee/add.html', [
        'user' => $user,
        'error' => true
      ]);
    }
  }
}
