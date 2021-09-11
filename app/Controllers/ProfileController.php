<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\Student;
use App\Models\Teacher;
use App\Utils\View;

class ProfileController
{
  public static function getProfile()
  {
    $session = $_SESSION['user'];
    $profile = $session['type'];

    if ($profile === 'employee') $user = Employee::getById($session['id']);
    else if ($profile === 'teacher') $user = Teacher::getById($session['id']);
    else $user = Student::getById($session['id']);

    $content = View::render('pages/profile', [
      'name' => $user->name,
      'document' => $user->document,
      'dateOfBirth' => $user->dateOfBirth,
      'email' => $user->email
    ]);
    return LayoutController::getLayout('Perfil', $content);
  }
}
