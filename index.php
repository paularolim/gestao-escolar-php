<?php

require __DIR__ . '/vendor/autoload.php';

$uri = explode('/', $_SERVER['REQUEST_URI']);
$uri = array_diff($uri, array(""));
$uri = array_values($uri);

include __DIR__ . '/app/routes/genericRoutes.php';
include __DIR__ . '/app/routes/teachersRoutes.php';

include __DIR__ . '/app/views/notFound.php';
