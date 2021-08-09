<?php

namespace App\controllers;

use App\Utils\View;

class LayoutController
{
  private static function getHeader(string $profile): string
  {
    return View::render('layouts/header-' . $profile);
  }

  public static function getLayout(string $profile, string $title, string $content)
  {
    return View::render('layouts/layout', [
      'title' => $title,
      'header' => self::getHeader($profile),
      'content' => $content
    ]);
  }
}
