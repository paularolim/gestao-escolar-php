<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class EmployeeController
{
  public static function getEmployees(int $page = 1, int $size = 20): string
  {
    $totalEmployees = Employee::getCount();
    $pagination = new Pagination($page, $size, $totalEmployees);
    $employees = Employee::getAll(['id', 'name', 'document'], null, null, $pagination->limit());

    $table = new Table(
      ['Nome', 'CPF', 'Ações'],
      ['name', 'document', 'button'],
      $employees,
      '/funcionarios'
    );

    $content = View::render('employee/list', [
      'total' => $totalEmployees,
      'table' => $table->render(),
      'pages' => $pagination->render('/funcionarios')
    ]);

    return LayoutController::getLayout('Funcionários', $content);
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
