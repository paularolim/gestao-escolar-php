<?php

namespace App\Controllers;

use App\Config\Sessions\EmployeeSession;
use App\Config\Sessions\Session;
use App\Config\Sessions\TeacherSession;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class DashboardController
{
  public static function getDashboard(ServerRequestInterface $request, ResponseInterface $response)
  {
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged() || TeacherSession::isLogged()) {
      return $view->render($response, 'Dashboard/' . Session::whoIsLogged() . '.html', [
        'name' => Session::getName(),
        'type' => Session::whoIsLogged()
      ]);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }
}
