<?php

namespace App\Controllers;

use App\Config\Session\Session;

class LogoutController
{
  public static function setLogout(): void
  {
    Session::logout();

    header('Location: /');
    exit;
  }
}
