<?php

namespace App\Http\Middlewares;

use App\Http\Request;
use App\Http\Response;
use App\Sessions\TeacherSession;
use Closure;

class RequiredTeacherLogin
{
  public function handle(Request $request, Closure $next): Response
  {
    if (!TeacherSession::isLogged())
      $request->getRouter()->redirect('/');

    return $next($request);
  }
}
