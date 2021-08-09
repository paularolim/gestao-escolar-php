<?php

use App\controllers\TeachersController;

$controller = new TeachersController();

if (count($uri) === 1 && $uri[0] === 'professores') {
  $controller->getAll();
  exit;
} else if (count($uri) === 2 && $uri[0] === 'professores' && $uri[1] === 'adicionar') {
  $controller->create();
  exit;
} else if (count($uri) === 2 && $uri[0] === 'professores') {
  $controller->getById($uri[1]);
  exit;
} else if (count($uri) === 3 && $uri[0] === 'professores' && $uri[2] === 'editar') {
  $controller->update();
  exit;
}