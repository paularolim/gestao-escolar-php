<?php

namespace App\Controllers;

use App\Models\Student;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class StudentController
{
  public static function getStudents(int $page = 1, int $size = 20): string
  {
    $totalStudents = Student::getCount();
    $pagination = new Pagination($page, $size, $totalStudents);
    $students = Student::getAll(['id', 'name', 'document'], null, null, $pagination->limit());

    $table = new Table(
      ['Nome', 'CPF', 'Ações'],
      ['name', 'document', 'button'],
      $students,
      '/alunos'
    );

    $content = View::render('student/list', [
      'total' => $totalStudents,
      'table' => $table->render(),
      'pages' => $pagination->render('/alunos')
    ]);

    return LayoutController::getLayout('Alunos', $content);
  }

  public static function getStudent(string $id)
  {
    $student = Student::getById($id, ['name', 'document', 'email', 'dateOfBirth']);

    $classes = Student::getClasses($id);

    $tableClasses = new Table(
      ['Série', 'Turma', 'Ações'],
      ['number', 'identifier', 'button'],
      $classes,
      '/funcionario/turma'
    );

    $content = View::render('student/profile', [
      'name' => $student->name,
      'document' => $student->document,
      'dateOfBirth' => $student->dateOfBirth,
      'email' => $student->email,
      'tableClasses' => $tableClasses->render()
    ]);

    return LayoutController::getLayout('Alunos', $content);
  }

  public static function getAddStudent()
  {
    $content = View::render('student/add');
    return LayoutController::getLayout('Alunos', $content);
  }

  public static function setAddStudent(array $body)
  {
    $student = new Student();
    $student->name = $body['name'];
    $student->dateOfBirth = $body['dateOfBirth'];
    $student->document = $body['document'];
    $student->email = $body['email'];
    $student->store();

    header('Location: /alunos');
    exit;
  }
}
