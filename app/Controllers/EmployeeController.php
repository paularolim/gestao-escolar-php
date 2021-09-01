<?php

namespace App\Controllers;

use App\Utils\View;

class EmployeeController
{
  const PROFILE = 'employee';

  public static function getDashboard() {
    $content = View::render('employee/dashboard'); 
    return LayoutController::getLayout(self::PROFILE, 'Funcionário', $content);
  }
}