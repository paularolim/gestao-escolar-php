<?php


namespace App\controllers;

use App\Utils\View;

class TeachersController
{
  const TABLE = 'teachers';

  public static function getDashboard(): string
  {
    $content = View::render('pages/dashboard-teachers');
    return LayoutController::getLayout(self::TABLE, 'Gestão Escolar - Dashboard', $content);
  }
}
