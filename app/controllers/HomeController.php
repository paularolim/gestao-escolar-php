<?php

namespace App\controllers;

use App\Utils\View;

class HomeController
{
  public static function getHome(): string
  {
    return View::render('pages/home');
  }
}
