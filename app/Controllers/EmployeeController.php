<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\Teacher;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class EmployeeController
{
  const PROFILE = 'employee';

  public static function getDashboard()
  {
    $content = View::render('employee/dashboard');
    return LayoutController::getLayout(self::PROFILE, 'Funcionário', $content);
  }

  public static function getTeachers(int $page = 1, int $size = 20): string
  {
    $totalTeachers = Teacher::getCount();
    $pagination = new Pagination($page, $size, $totalTeachers);
    $teachers = Teacher::getAll(['id', 'name', 'formation'], null, null, $pagination->limit());

    $table = new Table(
      ['Nome', 'Formação', 'Ações'],
      ['name', 'formation', 'button'],
      $teachers,
      '/funcionario/professor'
    );

    $content = View::render('employee/list-teachers', [
      'total' => $totalTeachers,
      'table' => $table->render(),
      'pages' => $pagination->render('/funcionario/professores')
    ]);

    return LayoutController::getLayout(self::PROFILE, 'Professores', $content);
  }

  public static function getTeacher(string $id)
  {
    $teacher = Teacher::getById($id, ['name', 'formation', 'document', 'email', 'dateOfBirth']);

    $content = View::render('employee/profile-teacher', [
      'name' => $teacher['name'],
      'formation' => $teacher['formation'],
      'document' => $teacher['document'],
      'dateOfBirth' => $teacher['dateOfBirth'],
      'email' => $teacher['email']
    ]);

    return LayoutController::getLayout(self::PROFILE, 'Professores', $content);
  }

  public static function getEmployees(int $page = 1, int $size = 20): string
  {
    $totalEmployees = Employee::getCount();
    $pagination = new Pagination($page, $size, $totalEmployees);
    $employees = Employee::getAll(['name', 'document'], null, null, $pagination->limit());

    $table = new Table(
      ['Nome', 'CPF', 'Ações'],
      ['name', 'document', 'button'],
      $employees,
      '/funcionario'
    );

    $content = View::render('employee/list-employees', [
      'total' => $totalEmployees,
      'table' => $table->render(),
      'pages' => $pagination->render('/funcionario/listar')
    ]);

    return LayoutController::getLayout(self::PROFILE, 'Funcionários', $content);
  }

  public static function getEmployee(string $id)
  {
    $employee = Employee::getById($id, ['name','document', 'email', 'dateOfBirth']);

    $content = View::render('employee/profile-employee', [
      'name' => $employee->name,
      'document' => $employee->document,
      'dateOfBirth' => $employee->dateOfBirth,
      'email' => $employee->email
    ]);

    return LayoutController::getLayout(self::PROFILE, 'Funcionários', $content);
  }
}
