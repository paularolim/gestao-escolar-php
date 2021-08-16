<?php

namespace App\Controllers;

use App\Utils\View;

class HomeController
{
  public static function getHome(string $errorTeacher = null): string
  {
    $messageTeacher = !is_null($errorTeacher) ? View::render('components/message-error', [
      'message' => $errorTeacher
    ]) : '';

    return View::render('pages/home', [
      'messageTeacher' => $messageTeacher
    ]);
  }
}
