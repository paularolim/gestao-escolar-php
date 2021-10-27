<?php

namespace App\Config\Session;

use App\Models\Student;

class StudentSession
{
  public static function login(Student $student): bool
  {
    self::init();

    $_SESSION['user'] = [
      'type' => 'student',
      'id' => $student->getId(),
      'name' => $student->getName()
    ];

    return true;
  }

  public static function isLogged(): bool
  {
    self::init();
    return (isset($_SESSION['user']['id']) && $_SESSION['user']['type'] === 'student');
  }

  private static function init()
  {
    // verify if session is actived
    if (session_status() !== PHP_SESSION_ACTIVE)
      session_start();
  }
}
