<?php

namespace App\Middlewares;

use App\Config\Session\EmployeeSession;
use App\Config\Session\StudentSession;
use App\Config\Session\TeacherSession;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class RequiredLogoutMiddleware
{
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    if (EmployeeSession::isLogged() || TeacherSession::isLogged() || StudentSession::isLogged()) {
      header('Location: /dashboard');
      exit;
    }

    $response = $handler->handle($request);
    $existingContent = (string) $response->getBody();

    $response = new Response();
    $response->getBody()->write($existingContent);

    return $response;
  }
}
