<?php

namespace App\Controllers;

use App\Config\Sessions\EmployeeSession;
use App\Config\Sessions\Session;
use App\Models\Employee;
use App\Utils\Pagination;
use App\Utils\View;
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
      $id = Session::getId();
      $type = ['type' => Session::whoIsLogged()];

      $total = ['total' => Employee::getCount()];
      $pagination = new Pagination($page, $size, $total['total']);
      $pages = $pagination->getInfo();
      $employees = ['employees' => Employee::getAll(['id', 'name', 'document'], null, null, $pagination->limit())];

      $args = (array)Employee::getById($id);
      $args = array_merge($args, $type, $employees, $total, $pages);

      return $view->render($response, 'Employee/list.html', $args);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }

  public static function getEmployee(string $id)
  {
    $employee = Employee::getById($id, ['name', 'document', 'email', 'dateOfBirth']);

    $content = View::render('employee/profile', [
      'name' => $employee->name,
      'document' => $employee->document,
      'dateOfBirth' => $employee->dateOfBirth,
      'email' => $employee->email
    ]);

    return LayoutController::getLayout('Funcionários', $content);
  }

  public static function getAddEmployee()
  {
    $content = View::render('employee/add');
    return LayoutController::getLayout('Funcionários', $content);
  }

  public static function setAddEmployee(array $body)
  {
    $employee = new Employee();
    $employee->name = $body['name'];
    $employee->dateOfBirth = $body['dateOfBirth'];
    $employee->document = $body['document'];
    $employee->email = $body['email'];
    $employee->store();

    header('Location: /funcionarios');
    exit;
  }
}
