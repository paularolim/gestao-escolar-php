<?php

namespace App\Controllers;

use App\Utils\View;

class DashboardController
{
  public static function getDashboard()
  {
    $profile = $_SESSION['user']['type'];
    
    $content = View::render('pages/dashboard-'.$profile);
    return LayoutController::getLayout('Dashboard', $content);
  }
}
