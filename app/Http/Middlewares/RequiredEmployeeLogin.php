<?php

namespace App\Http\Middlewares;

use App\Http\Request;
use App\Http\Response;
use App\Sessions\EmployeeSession;
use Closure;

class RequiredEmployeeLogin
{
  public function handle(Request $request, Closure $next): Response
  {
    if (!EmployeeSession::isLogged())
      $request->getRouter()->redirect('/');

    return $next($request);
  }
}
