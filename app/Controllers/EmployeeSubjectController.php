<?php

namespace App\Controllers;

use App\Models\Subject;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class EmployeeSubjectController
{
  const PROFILE = 'employee';

  public static function getSubjects(int $page = 1, int $size = 20)
  {
    $totalSubjects = Subject::getCount();
    $pagination = new Pagination($page, $size, $totalSubjects);
    $subjects = Subject::getAll(['id', 'name', 'workload'], null, null, $pagination->limit());

    $table = new Table(
      ['Matéria', 'Carga horária', 'Ações'],
      ['name', 'workload', 'button'],
      $subjects,
      '/funcionario/materia'
    );

    $content = View::render('employee/subject/list', [
      'total' => $totalSubjects,
      'table' => $table->render(),
      'pages' => $pagination->render('/funcionario/materias')
    ]);

    return LayoutController::getLayout(self::PROFILE, 'Funcionários', $content);
  }

  public static function getAddSubject()
  {
    $content = View::render('/employee/subject/add');
    return LayoutController::getLayout(self::PROFILE, 'Funcionários', $content);
  }

  public static function setAddSubject(array $body)
  {
    $subject = new Subject();
    $subject->name = $body['name'];
    $subject->workload = $body['workload'];
    $subject->store();

    header('Location: /funcionario/materias');
    exit;
  }
}
