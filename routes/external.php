<?php

use App\Http\Response;
use App\Controllers\HomeController;

$router->get('/', [
  function () {
    return new Response(HomeController::getHome());
  }
]);