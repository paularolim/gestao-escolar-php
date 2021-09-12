<?php

namespace App\Controllers;

use App\Models\Subject;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class SubjectController
{
  public static function getSubjects(int $page = 1, int $size = 20)
  {
    $totalSubjects = Subject::getCount();
    $pagination = new Pagination($page, $size, $totalSubjects);
    $subjects = Subject::getAll(['id', 'name', 'workload'], null, null, $pagination->limit());

    $table = new Table(
      ['Matéria', 'Carga horária', 'Ações'],
      ['name', 'workload', 'button'],
      $subjects,
      '/materias'
    );

    $content = View::render('subject/list', [
      'total' => $totalSubjects,
      'table' => $table->render(),
      'pages' => $pagination->render('/materias')
    ]);

    return LayoutController::getLayout('Funcionários', $content);
  }

  public static function getSubject(string $id)
  {
    // TODO: show teachers who teach the subject
    $subject = Subject::getById($id);

    $content = View::render('subject/details', [
      'name' => $subject->name,
      'workload' => $subject->workload
    ]);
    return LayoutController::getLayout('Matérias', $content);
  }

  public static function getAddSubject()
  {
    $content = View::render('/subject/add');
    return LayoutController::getLayout('Funcionários', $content);
  }

  public static function setAddSubject(array $body)
  {
    $subject = new Subject();
    $subject->name = $body['name'];
    $subject->workload = $body['workload'];
    $subject->store();

    header('Location: /materias');
    exit;
  }
}
