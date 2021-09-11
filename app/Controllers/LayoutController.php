<?php

namespace App\Controllers;

use App\Utils\View;

class LayoutController
{
  const TITLE = 'Gestão Escolar - ';

  private static function getHeader(string $profile): string
  {
    $user = $_SESSION['user'];

    return View::render('layouts/header-' . $profile, [
      'name' => $user['name'] ?? 'Nome'
    ]);
  }

  public static function getLayout(string $title, string $content)
  {
    $profile = $_SESSION['user']['type'];
    
    return View::render('layouts/layout', [
      'title' => self::TITLE . $title,
      'header' => self::getHeader($profile),
      'content' => $content
    ]);
  }
}
