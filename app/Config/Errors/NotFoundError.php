<?php

namespace App\Config\Errors;

use App\Controllers\LayoutController;
use App\Utils\View;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class NotFoundError implements ErrorRendererInterface
{
  public function __invoke(Throwable $exception, bool $displayErrorDetails): string
  {
    // TODO: get profile from session
    $view = View::render('layouts/404error');
    return LayoutController::getLayout('employee', 'Não encontrado', $view);
  }
}