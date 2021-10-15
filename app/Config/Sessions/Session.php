<?php

namespace App\Config\Sessions;

class Session
{
  private static function init()
  {
    if (session_status() !== PHP_SESSION_ACTIVE)
      session_start();
  }

  public static function whoIsLogged()
  {
    self::init();

    if (isset($_SESSION['user']['id'])) {
      return $_SESSION['user']['type'];
    } else {
      throw new \Error('User is not logged');
    }
  }

  public static function getId()
  {
    self::init();

    if (isset($_SESSION['user']['id'])) {
      return $_SESSION['user']['id'];
    } else {
      throw new \Error('User is not logged');
    }
  }

  public static function getName()
  {
    self::init();

    if (isset($_SESSION['user']['name'])) {
      return $_SESSION['user']['name'];
    } else {
      throw new \Error('User is not logged');
    }
  }
}
