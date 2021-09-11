<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Config\Sessions\EmployeeSession;
use App\Utils\View;

class LoginController
{
  public static function getLogin(string $messageEmployee = null)
  {
    if ($messageEmployee) $messageEmployee = View::render('pages/components/message-error', ['message' => $messageEmployee]);

    return View::render('pages/home', [
      'messageEmployee' => $messageEmployee
    ]);
  }

  public static function setLogin(string $profile, string $document, string $password)
  {
    if ($profile === 'employee') {
      return self::loginEmployee($document, $password);
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
}
