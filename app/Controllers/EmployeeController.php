<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class EmployeeController
{
  // const PROFILE = 'employee';

  // public static function getTeachers(int $page = 1, int $size = 20): string
  // {
  //   $totalTeachers = Teacher::getCount();
  //   $pagination = new Pagination($page, $size, $totalTeachers);
  //   $teachers = Teacher::getAll(['id', 'name', 'formation'], null, null, $pagination->limit());

  //   $table = new Table(
  //     ['Nome', 'Formação', 'Ações'],
  //     ['name', 'formation', 'button'],
  //     $teachers,
  //     '/funcionario/professor'
  //   );

  //   $content = View::render('employee/list-teachers', [
  //     'total' => $totalTeachers,
  //     'table' => $table->render(),
  //     'pages' => $pagination->render('/funcionario/professores')
  //   ]);

  //   return LayoutController::getLayout('Professores', $content);
  // }

  // public static function getTeacher(string $id)
  // {
  //   $teacher = Teacher::getById($id, ['name', 'formation', 'document', 'email', 'dateOfBirth']);

  //   $content = View::render('employee/profile-teacher', [
  //     'name' => $teacher->name,
  //     'formation' => $teacher->formation,
  //     'document' => $teacher->document,
  //     'dateOfBirth' => $teacher->dateOfBirth,
  //     'email' => $teacher->email
  //   ]);

  //   return LayoutController::getLayout('Professores', $content);
  // }

  // public static function getAddTeacher()
  // {
  //   $content = View::render('employee/add-teacher');
  //   return LayoutController::getLayout('Professores', $content);
  // }

  // public static function setAddTeacher(array $body)
  // {
  //   $teacher = new Teacher();
  //   $teacher->name = $body['name'];
  //   $teacher->dateOfBirth = $body['dateOfBirth'];
  //   $teacher->document = $body['document'];
  //   $teacher->email = $body['email'];
  //   $teacher->formation = $body['formation'];
  //   $teacher->store();

  //   header('Location: /funcionario/professores');
  //   exit;
  // }

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

  // public static function getStudents(int $page = 1, int $size = 20): string
  // {
  //   $totalStudents = Student::getCount();
  //   $pagination = new Pagination($page, $size, $totalStudents);
  //   $students = Student::getAll(['id', 'name', 'document'], null, null, $pagination->limit());

  //   $table = new Table(
  //     ['Nome', 'CPF', 'Ações'],
  //     ['name', 'document', 'button'],
  //     $students,
  //     '/funcionario/aluno'
  //   );

  //   $content = View::render('employee/list-students', [
  //     'total' => $totalStudents,
  //     'table' => $table->render(),
  //     'pages' => $pagination->render('/funcionario/alunos')
  //   ]);

  //   return LayoutController::getLayout('Alunos', $content);
  // }

  // public static function getStudent(string $id)
  // {
  //   $student = Student::getById($id, ['name', 'document', 'email', 'dateOfBirth']);

  //   $classes = Student::getClasses($id);

  //   $tableClasses = new Table(
  //     ['Série', 'Turma', 'Ações'],
  //     ['number', 'identifier', 'button'],
  //     $classes,
  //     '/funcionario/turma'
  //   );

  //   $content = View::render('employee/profile-student', [
  //     'name' => $student->name,
  //     'document' => $student->document,
  //     'dateOfBirth' => $student->dateOfBirth,
  //     'email' => $student->email,
  //     'tableClasses' => $tableClasses->render()
  //   ]);

  //   return LayoutController::getLayout('Alunos', $content);
  // }

  // public static function getAddStudent()
  // {
  //   $content = View::render('employee/add-student');
  //   return LayoutController::getLayout('Alunos', $content);
  // }

  // public static function setAddStudent(array $body)
  // {
  //   $student = new Student();
  //   $student->name = $body['name'];
  //   $student->dateOfBirth = $body['dateOfBirth'];
  //   $student->document = $body['document'];
  //   $student->email = $body['email'];
  //   $student->store();

  //   header('Location: /funcionario/alunos');
  //   exit;
  // }

  // public static function getClasses(int $page = 1, int $size = 20): string
  // {
  //   $totalClasses = SchoolClass::getCount();
  //   $pagination = new Pagination($page, $size, $totalClasses);
  //   $classes = SchoolClass::getAll(null, null, null, $pagination->limit());

  //   $table = new Table(
  //     ['Série', 'Turma', 'Ano', 'Ações'],
  //     ['number', 'identifier', 'year', 'button'],
  //     $classes,
  //     '/funcionario/turma'
  //   );

  //   $content = View::render('employee/list-classes', [
  //     'total' => $totalClasses,
  //     'table' => $table->render(),
  //     'pages' => $pagination->render('/funcionario/turmas')
  //   ]);

  //   return LayoutController::getLayout('Turmas', $content);
  // }

  // public static function getClass(string $id)
  // {
  //   $class = SchoolClass::getById($id);
  //   $students = SchoolClass::getStudents($id);

  //   $tableStudents = new Table(
  //     ['Nome', 'CPF', 'Ações'],
  //     ['name', 'document', 'button'],
  //     $students,
  //     '/funcionario/aluno'
  //   );

  //   $content = View::render('employee/details-class', [
  //     'number' => $class->number,
  //     'identifier' => $class->identifier,
  //     'maxStudents' => $class->maxStudents,
  //     'tableStudents' => $tableStudents->render(),
  //     'totalStudents' => count($students)
  //   ]);

  //   return LayoutController::getLayout('Turmas', $content);
  // }

  // public static function getAddClass()
  // {
  //   $content = View::render('employee/add-class');
  //   return LayoutController::getLayout('Turmas', $content);
  // }

  // public static function setAddClass(array $body)
  // {
  //   $class = new SchoolClass();
  //   $class->number = $body['number'];
  //   $class->identifier = $body['identifier'];
  //   $class->year = $body['year'];
  //   $class->maxStudents = $body['maxStudents'];
  //   $class->store();

  //   header('Location: /funcionario/turmas');
  //   exit;
  // }
}
