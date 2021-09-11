<?php

namespace App\Config\Sessions;

use App\Models\Employee;

class EmployeeSession
{
  public static function login(Employee $employee): bool
  {
    self::init();

    $_SESSION['user'] = [
      'type' => 'employee',
      'id' => $employee->id,
      'name' => $employee->name
    ];

    return true;
  }

  public static function logout(): bool
  {
    self::init();

    unset($_SESSION['user']);

    return true;
  }

  public static function isLogged(): bool
  {
    self::init();

    return isset($_SESSION['user']['id']);
  }

  private static function init()
  {
    // verify if session is actived
    if (session_status() !== PHP_SESSION_ACTIVE)
      session_start();
  }
}
