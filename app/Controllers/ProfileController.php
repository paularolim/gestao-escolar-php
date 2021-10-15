<?php

namespace App\Controllers;

use App\Config\Sessions\Session;
use App\Config\Sessions\EmployeeSession;
use App\Config\Sessions\TeacherSession;
use App\Models\Employee;
use App\Models\Teacher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ProfileController
{
  public static function getProfile(ServerRequestInterface $request, ResponseInterface $response)
  {
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $id = Session::getId();
      $args = (array)Employee::getById($id);
    } else if (TeacherSession::isLogged()) {
      $id = Session::getId();
      $args = (array)Teacher::getById($id);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }

    $type = ['type' => Session::whoIsLogged()];
    $args = array_merge($args, $type);

    return $view->render($response, 'Profile/profile.html', $args);
  }
}
