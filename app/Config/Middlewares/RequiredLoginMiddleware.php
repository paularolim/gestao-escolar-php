<?php

namespace App\Config\Middlewares;

use App\Config\Sessions\EmployeeSession;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class RequiredLoginMiddleware
{
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    if (!EmployeeSession::isLogged()) {
      header('Location: /');
      exit;
    }

    $response = $handler->handle($request);
    $existingContent = (string) $response->getBody();

    $response = new Response();
    $response->getBody()->write($existingContent);

    return $response;
  }
}
