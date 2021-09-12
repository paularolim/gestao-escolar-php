<?php

namespace App\Controllers;

use App\Models\Teacher;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;

class TeacherController
{
  public static function getTeachers(int $page = 1, int $size = 20): string
  {
    $totalTeachers = Teacher::getCount();
    $pagination = new Pagination($page, $size, $totalTeachers);
    $teachers = Teacher::getAll(['id', 'name', 'formation'], null, null, $pagination->limit());

    $table = new Table(
      ['Nome', 'Formação', 'Ações'],
      ['name', 'formation', 'button'],
      $teachers,
      '/professores'
    );

    $content = View::render('teacher/list', [
      'total' => $totalTeachers,
      'table' => $table->render(),
      'pages' => $pagination->render('/professores')
    ]);

    return LayoutController::getLayout('Professores', $content);
  }

  public static function getTeacher(string $id)
  {
    // TODO: show subjects 
    $teacher = Teacher::getById($id, ['name', 'formation', 'document', 'email', 'dateOfBirth']);

    $content = View::render('teacher/profile', [
      'name' => $teacher->name,
      'formation' => $teacher->formation,
      'document' => $teacher->document,
      'dateOfBirth' => $teacher->dateOfBirth,
      'email' => $teacher->email
    ]);

    return LayoutController::getLayout('Professores', $content);
  }

  public static function getAddTeacher()
  {
    $content = View::render('teacher/add');
    return LayoutController::getLayout('Professores', $content);
  }

  public static function setAddTeacher(array $body)
  {
    $teacher = new Teacher();
    $teacher->name = $body['name'];
    $teacher->dateOfBirth = $body['dateOfBirth'];
    $teacher->document = $body['document'];
    $teacher->email = $body['email'];
    $teacher->formation = $body['formation'];
    $teacher->store();

    header('Location: /professores');
    exit;
  }
}
