<?php

namespace App\Controllers;

use App\Models\Teacher;
use App\Utils\Pagination;
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
    $teachers = Teacher::getAll(['name', 'formation'], null, null, $pagination->limit());

    $rows = '';
    foreach ($teachers as $teacher) {
      $rows .= View::render('employee/components/table-tr-teachers', [
        'id' => $teacher['id'],
        'name' => $teacher['name'],
        'formation' => $teacher['formation']
      ]);
    }

    $content = View::render('employee/list-teachers', [
      'total' => $totalTeachers,
      'rows' => $rows,
      'pages' => $pagination->render('/funcionario/professores')
    ]);

    return LayoutController::getLayout(self::PROFILE, 'Professores', $content);
  }
}
