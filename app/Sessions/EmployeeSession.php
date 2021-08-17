<?php

namespace App\Sessions;

use App\Models\Employee;

class EmployeeSession
{
  public static function login(Employee $employee): bool
  {
    self::init();

    $_SESSION['employee'] = [
      'id' => $employee->id,
      'name' => $employee->name
    ];

    return true;
  }

  public static function logout(): bool
  {
    self::init();

    unset($_SESSION['employee']);

    return true;
  }

  public static function isLogged(): bool
  {
    self::init();

    return isset($_SESSION['employee']['id']);
  }

  private static function init()
  {
    // verify if session is actived
    if (session_status() !== PHP_SESSION_ACTIVE)
      session_start();
  }
}
