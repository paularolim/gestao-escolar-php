<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\Session;
use App\Models\Teacher;
use App\Utils\Pagination;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class TeacherController
{
  public static function getTeachers(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $page = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $total = Teacher::getCount();
      $pagination = new Pagination($page, $size, $total);
      $pages = $pagination->getInfo();
      $teachers = Teacher::getAll(['id', 'name', 'document', 'formation', 'active'], null, 'name ASC', $pagination->limit());

      return $view->render($response, 'Teacher/list.html', [
        'user' => Session::getUser(),
        'teachers' => $teachers,
        'total' => $total,
        'pages' => $pages
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => Session::getUser()
    ]);
  }

  public static function getTeacher(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $id = $params['id'];

    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $teacher = Teacher::getById($id, ['name', 'document', 'email', 'phone', 'dateOfBirth', 'formation', 'active']);

      return $view->render($response, 'Teacher/details.html', [
        'user' => Session::getUser(),
        'teacher' => $teacher
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => Session::getUser()
    ]);
  }

  public static function getAddTeacher(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      return $view->render($response, 'Teacher/add.html', [
        'user' => $user
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function setAddTeacher(ServerRequestInterface $request, ResponseInterface $response)
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    $body = $request->getParsedBody();

    $teacher = new Teacher();
    $teacher->setName($body['name']);
    $teacher->setDateOfBirth($body['dateOfBirth']);
    $teacher->setDocument($body['document']);
    $teacher->setEmail($body['email']);
    $teacher->setFormation($body['formation']);

    try {
      $teacher->store();
      header('Location: /professores');
      exit;
    } catch (Error $e) {
      return $view->render($response, 'Teacher/add.html', [
        'user' => $user,
        'error' => true
      ]);
    }
  }
}
