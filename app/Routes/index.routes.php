<?php

use Slim\App;

return function (App $app) {
  (require_once('basic.routes.php'))($app);
  (require_once('employee.routes.php'))($app);
  (require_once('teacher.routes.php'))($app);
  (require_once('students.routes.php'))($app);
  (require_once('subject.routes.php'))($app);
  (require_once('schoolClasses.routes.php'))($app);
};
