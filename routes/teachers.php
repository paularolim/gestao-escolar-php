<?php

use App\Controllers\TeachersController;
use App\Http\Response;

$router->get('/professores', [
  function () {
    return new Response(TeachersController::getDashboard());
  }
]);