<?php

namespace App\Controllers;

use App\Models\Teacher;
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
  { // TODO: calculate page
    $totalTeachers = Teacher::getCount();
    $totalPages = ceil($totalTeachers / $size);
    $startItem = ($size * $page) - $size;

    $teachers = Teacher::getAll(['name', 'formation'], null, null, $startItem . ',' . $size);

    $rows = '';
    foreach ($teachers as $teacher) {
      $rows .= View::render('employee/components/table-tr-teachers', [
        'id' => $teacher['id'],
        'name' => $teacher['name'],
        'formation' => $teacher['formation']
      ]);
    }

    $pagination = '';
    for ($i = 0; $i < $totalPages; $i++) {
      $pagination .= View::render('employee/components/pagination-number', [
        'URL' => '/funcionario/professores',
        'page' => $i + 1,
        'size' => $size,
        'active' => $page === ($i + 1) ? 'w3-blue' : ''
      ]);
    }

    $content = View::render('employee/list-teachers', [
      'rows' => $rows,
      'pages' => $pagination
    ]);

    return LayoutController::getLayout(self::PROFILE, 'Professores', $content);
  }
}
