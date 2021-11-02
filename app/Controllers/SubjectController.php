<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\Session;
use App\Config\Session\TeacherSession;
use App\Models\Subject;
use App\Models\Teacher;
use App\Utils\Pagination;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SubjectController
{

  public static function getAll(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $page = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      $total = (int)Subject::getAll(['count(*) as total'])[0]['total'];
      $pagination = new Pagination($page, $size, $total);
      $pages = $pagination->getInfo();
      $subjects = Subject::getAll(['id', 'title', 'workload', 'passingScore']);

      return $view->render($response, 'Subject/list.html', [
        'user' => $user,
        'total' => $total,
        'subjects' => $subjects,
        'pages' => $pages
      ]);
    } else if (TeacherSession::isLogged()) {
      $subjects = Teacher::getSubjects($user['id']);
      $total = count($subjects);
      $pagination = new Pagination(1, $total, $total);
      $pages = $pagination->getInfo();

      return $view->render($response, 'Subject/list.html', [
        'user' => $user,
        'total' => $total,
        'subjects' => $subjects,
        'pages' => $pages
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function getOne(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $id = $params['id'];
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    $subject = Subject::getById($id, ['id', 'title', 'workload', 'passingScore']);
    if ((EmployeeSession::isLogged() || TeacherSession::isLogged()) && !!$subject) {
      return $view->render($response, 'Subject/details.html', [
        'user' => $user,
        'subject' => $subject
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
      return $view->render($response, 'Subject/add.html', [
        'user' => $user,
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function setAdd(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $body = $request->getParsedBody();
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    $subject = new Subject();
    $subject->setTitle($body['title']);
    $subject->setWorkload($body['workload']);
    $subject->setPassingScore($body['passingScore']);

    try {
      $subject->store();
      header('Location: /materias');
      exit;
    } catch (Error $e) {
      return $view->render($response, 'Subject/add.html', [
        'user' => $user,
        'error' => true
      ]);
    }
  }
}
