<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Config\Sessions\EmployeeSession;
use App\Models\Teacher;
use App\Config\Sessions\TeacherSession;
use App\Utils\View;

class LoginController
{
  public static function getLogin(string $messageEmployee = null, string $messageTeacher = null)
  {
    if ($messageEmployee) $messageEmployee = View::render('pages/components/message-error', ['message' => $messageEmployee]);
    if ($messageTeacher) $messageTeacher = View::render('pages/components/message-error', ['message' => $messageTeacher]);

    return View::render('pages/home', [
      'messageEmployee' => $messageEmployee,
      'messageTeacher' => $messageTeacher
    ]);
  }

  public static function setLogin(string $profile, string $document, string $password)
  {
    if ($profile === 'employee') {
      return self::loginEmployee($document, $password);
    }
    else if($profile === 'teacher') {
      return self::loginTeacher($document, $password);
    }
  }

  public static function logout()
  {
    EmployeeSession::logout();

    header('Location: /');
    exit;
  }

  private static function loginEmployee(string $document, string $password)
  {
    $employee = Employee::getByDocument($document);

    if (!$employee instanceof Employee) {
      return LoginController::getLogin('Documento incorreto');
    }

    if (!password_verify($password, $employee->password)) {
      return LoginController::getLogin('Senha incorreta');
    }

    EmployeeSession::login($employee);

    header('Location: /dashboard');
    exit;
  }

  private static function loginTeacher(string $document, string $password)
  {
    $teacher = Teacher::getByDocument($document);

    if(!$teacher instanceof Teacher) {
      return LoginController::getLogin(null, 'Documento incorreto');
    }

    if (!password_verify($password, $teacher->password)) {
      return LoginController::getLogin(null, 'Senha incorreta');
    }

    TeacherSession::login($teacher);

    header('Location: /dashboard');
    exit;
  }
}
