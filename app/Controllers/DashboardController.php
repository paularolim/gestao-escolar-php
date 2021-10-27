<?php

namespace App\Controllers;

use App\Config\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class DashboardController
{
  public static function getDashboardScreen(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    return $view->render($response, 'Dashboard/index.html', [
      'user' => $user
    ]);
  }
}
