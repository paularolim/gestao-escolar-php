<?php

use Slim\App;

return function (App $app) {
  (require_once('basic.routes.php'))($app);
  (require_once('employee.routes.php'))($app);
};
