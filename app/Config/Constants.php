<?php

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../.env');

define('URL', $_ENV['URL']);
define('DBHOST', $_ENV['DBHOST']);
define('DBDATABASE', $_ENV['DBDATABASE']);
define('DBUSER', $_ENV['DBUSER']);
define('DBPASS', $_ENV['DBPASS']);
