<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\Session;
use App\Models\Employee;
use App\Models\SchoolClass;
use App\Utils\Pagination;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SchoolClassController
{
  public static function getAll(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $page = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $total = SchoolClass::getAll(['count(*) as total'])[0]['total'];
      $pagination = new Pagination($page, $size, $total);
      $pages = $pagination->getInfo();
      $schoolClasses = SchoolClass::getAll();

      return $view->render($response, 'SchoolClass/list.html', [
        'user' => Session::getUser(),
        'schoolClasses' => $schoolClasses,
        'total' => $total,
        'pages' => $pages
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => Session::getUser()
    ]);
  }

  public static function getOne(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $id = $params['id'];
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    $schoolClass = SchoolClass::getById($id, ['*']);
    if (EmployeeSession::isLogged() && !!$schoolClass) {

      return $view->render($response, 'SchoolClass/details.html', [
        'user' => $user,
        'schoolClass' => $schoolClass
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function getAdd(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      return $view->render($response, 'SchoolClass/add.html', [
        'user' => $user
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function setAdd(ServerRequestInterface $request, ResponseInterface $response)
  {
    $body = $request->getParsedBody();
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    $schoolClass = new SchoolClass();
    $schoolClass->setIdentifier($body['identifier']);
    $schoolClass->setYear($body['year']);
    $schoolClass->setMaxStudents($body['maxStudents']);

    try {
      $schoolClass->store();
      header('Location: /turmas');
      exit;
    } catch (Error $e) {
      die($e);
      return $view->render($response, 'SchoolClass/add.html', [
        'user' => $user,
        'error' => true
      ]);
    }
  }
}
