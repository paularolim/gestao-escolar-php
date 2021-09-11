<?php

namespace App\Sessions;

use App\Models\Teacher;

class TeacherSession
{
  public static function login(Teacher $teacher): bool
  {
    self::init();

    $_SESSION['teacher'] = [
      'id' => $teacher->id,
      'name' => $teacher->name
    ];

    return true;
  }

  public static function logout(): bool
  {
    self::init();

    unset($_SESSION['teacher']);

    return true;
  }

  public static function isLogged(): bool
  {
    self::init();

    return isset($_SESSION['teacher']['id']);
  }

  private static function init()
  {
    // verify if session is actived
    if (session_status() !== PHP_SESSION_ACTIVE)
      session_start();
  }
}
