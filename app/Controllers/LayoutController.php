<?php

namespace App\Controllers;

use App\Utils\View;

class LayoutController
{
  const TITLE = 'Gestão Escolar - ';

  private static function getHeader(string $profile): string
  {
    $user = $_SESSION[$profile];

    return View::render('layouts/header-' . $profile, [
      'name' => $user['name'] ?? 'Nome'
    ]);
  }

  public static function getLayout(string $profile, string $title, string $content)
  {
    return View::render('layouts/layout', [
      'title' => self::TITLE . $title,
      'header' => self::getHeader($profile),
      'content' => $content
    ]);
  }
}
