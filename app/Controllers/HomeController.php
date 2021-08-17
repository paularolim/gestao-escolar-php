<?php

namespace App\Controllers;

use App\Utils\View;

class HomeController
{
  public static function getHome(string $profile = null, string $error = null): string
  {
    $messageTeacher = !is_null($error) && $profile == 'teacher'
      ? View::render('components/message-error', [
        'message' => $error
      ])
      : '';

    $messageEmployee = !is_null($error) && $profile == 'employee'
      ? View::render('components/message-error', [
        'message' => $error
      ])
      : '';

    return View::render('pages/home', [
      'messageTeacher' => $messageTeacher,
      'messageEmployee' => $messageEmployee
    ]);
  }
}
