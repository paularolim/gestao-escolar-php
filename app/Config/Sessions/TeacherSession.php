<?php

namespace App\Config\Sessions;

use App\Models\Teacher;

class TeacherSession
{
  public static function login(Teacher $teacher): bool
  {
    self::init();

    $_SESSION['user'] = [
      'type' => 'teacher',
      'id' => $teacher->id,
      'name' => $teacher->name
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

    return (isset($_SESSION['user']['id']) && $_SESSION['user']['type'] === 'teacher');
  }

  private static function init()
  {
    // verify if session is actived
    if (session_status() !== PHP_SESSION_ACTIVE)
      session_start();
  }
}
