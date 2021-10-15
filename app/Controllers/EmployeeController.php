<?php

namespace App\Controllers;

use App\Config\Sessions\EmployeeSession;
use App\Config\Sessions\Session;
use App\Models\Employee;
use App\Utils\Pagination;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class EmployeeController
{
  private static function getUserInfo(): array
  {
    $id = Session::getId();

    return array_merge(
      ['type' => Session::whoIsLogged()],
      (array)Employee::getById($id)
    );
  }

  public static function getEmployees(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $page = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $total = ['total' => Employee::getCount()];
      $pagination = new Pagination($page, $size, $total['total']);
      $pages = $pagination->getInfo();
      $employees = ['employees' => Employee::getAll(['id', 'name', 'document'], null, null, $pagination->limit())];

      $args = self::getUserInfo();
      $args = array_merge($args, $employees, $total, $pages);

      return $view->render($response, 'Employee/list.html', $args);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }

  public static function getEmployee(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $employeeId = $params['id'];

    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $employee = ['employee' => (array)Employee::getById($employeeId, ['name', 'document', 'email', 'dateOfBirth'])];

      $args = self::getUserInfo();
      $args = array_merge($args, $employee);

      return $view->render($response, 'Employee/details.html', $args);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }

  public static function getAddEmployee(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $args = self::getUserInfo();

      return $view->render($response, 'Employee/add.html', $args);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }

  public static function setAddEmployee(ServerRequestInterface $request, ResponseInterface $response)
  {
    $view = Twig::fromRequest($request);

    $body = $request->getParsedBody();

    $employee = new Employee();
    $employee->name = $body['name'];
    $employee->dateOfBirth = $body['dateOfBirth'];
    $employee->document = $body['document'];
    $employee->email = $body['email'];

    try {
      $employee->store();
      header('Location: /funcionarios');
      exit;
    } catch (Error $e) {
      $error = ['error' => 'Não foi possível adicionar este funcionário'];

      $args = self::getUserInfo();
      $args = array_merge($args, $error);

      return $view->render($response, 'Employee/add.html', $args);
    }
  }
}
