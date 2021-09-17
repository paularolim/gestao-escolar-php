<?php

namespace App\Controllers;

use App\Models\SchoolClass;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class SchoolClassController
{
  public static function getSchoolClasses(int $page = 1, int $size = 20): string
  {
    $totalClasses = SchoolClass::getCount();
    $pagination = new Pagination($page, $size, $totalClasses);
    $classes = SchoolClass::getAll(null, null, null, $pagination->limit());

    $table = new Table(
      ['Série', 'Turma', 'Ano', 'Ações'],
      ['number', 'identifier', 'year', 'button'],
      $classes,
      '/turmas'
    );

    $content = View::render('schoolClass/list', [
      'total' => $totalClasses,
      'table' => $table->render(),
      'pages' => $pagination->render('/turmas')
    ]);

    return LayoutController::getLayout('Turmas', $content);
  }

  public static function getSchoolClass(string $id)
  {
    $class = SchoolClass::getById($id);
    $students = SchoolClass::getStudents($id);

    $tableStudents = new Table(
      ['Nome', 'CPF', 'Ações'],
      ['name', 'document', 'button'],
      $students,
      '/alunos'
    );

    $content = View::render('schoolClass/details', [
      'id' => $class->id,
      'number' => $class->number,
      'identifier' => $class->identifier,
      'maxStudents' => $class->maxStudents,
      'tableStudents' => $tableStudents->render(),
      'totalStudents' => count($students),
    ]);

    return LayoutController::getLayout('Turmas', $content);
  }

  public static function getAddSchoolClass()
  {
    $content = View::render('schoolClass/add');
    return LayoutController::getLayout('Turmas', $content);
  }

  public static function setAddSchoolClass(array $body)
  {
    $class = new SchoolClass();
    $class->number = $body['number'];
    $class->identifier = $body['identifier'];
    $class->year = $body['year'];
    $class->maxStudents = $body['maxStudents'];
    $class->store();

    header('Location: /turmas');
    exit;
  }
}
