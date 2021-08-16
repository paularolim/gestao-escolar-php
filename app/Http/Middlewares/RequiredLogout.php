<?php

namespace App\Http\Middlewares;

use App\Http\Request;
use App\Http\Response;
use App\Sessions\TeacherSession;
use Closure;

class RequiredLogout
{
  public function handle(Request $request, Closure $next): Response
  {
    // verify if is logged as teacher
    if (TeacherSession::isLogged())
      $request->getRouter()->redirect('/professores');

    return $next($request);
  }
}
