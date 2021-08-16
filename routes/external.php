<?php

use App\Http\Response;
use App\Controllers\HomeController;

$router->get('/', [
  'middlewares' => [
    'requiredLogout'
  ],
  function () {
    return new Response(HomeController::getHome());
  }
]);
