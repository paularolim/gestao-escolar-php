<?php

require __DIR__ . '/vendor/autoload.php';

use App\controllers\HomeController;
use App\controllers\TeachersController;

// echo HomeController::getHome();
echo TeachersController::getDashboard();
