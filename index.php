<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\TeachersController;

// echo HomeController::getHome();
echo TeachersController::getDashboard();
