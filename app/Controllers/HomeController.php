<?php

namespace App\Controllers;

use App\Utils\View;

class HomeController
{
  public static function getHome(): string
  {
    return View::render('pages/home');
  }
}
