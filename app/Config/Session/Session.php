<?php

namespace App\Config\Session;

class Session
{
  private static function init()
  {
    if (session_status() !== PHP_SESSION_ACTIVE)
      session_start();
  }

  public static function getUser()
  {
    self::init();

    if (isset($_SESSION['user']['id'])) {
      return $_SESSION['user'];
    } else {
      throw new \Error('User is not logged');
    }
  }
}
