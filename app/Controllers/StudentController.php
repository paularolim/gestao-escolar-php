<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\Session;
use App\Models\Student;
use App\Utils\Pagination;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class StudentController
{
  public static function getStudents(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $page = $request->getQueryParams()['page'] ?? 1;
    $size = $request->getQueryParams()['size'] ?? 20;
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $total = Student::getCount();
      $pagination = new Pagination($page, $size, $total);
      $pages = $pagination->getInfo();
      $students = Student::getAll(['id', 'name', 'document', 'active', 'matriculation'], null, 'name ASC', $pagination->limit());

      return $view->render($response, 'Student/list.html', [
        'user' => Session::getUser(),
        'students' => $students,
        'total' => $total,
        'pages' => $pages
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => Session::getUser()
    ]);
  }

  public static function getStudent(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $id = $params['id'];

    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      $student = Student::getById($id, ['name', 'document', 'phone', 'email', 'dateOfBirth', 'active', 'matriculation']);

      return $view->render($response, 'Student/details.html', [
        'user' => $user,
        'student' => $student
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function getAddStudent(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      return $view->render($response, 'Student/add.html', [
        'user' => $user
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function setAddStudent(ServerRequestInterface $request, ResponseInterface $response)
  {
    $view = Twig::fromRequest($request);

    $user = Session::getUser();

    $body = $request->getParsedBody();

    $student = new Student();
    $student->setName($body['name']);
    $student->setDateOfBirth($body['dateOfBirth']);
    $student->setDocument($body['document']);
    $student->setEmail($body['email']);

    try {
      $student->store();
      header('Location: /alunos');
      exit;
    } catch (Error $e) {
      die($e);
      return $view->render($response, 'Student/add.html', [
        'user' => $user,
        'error' => true
      ]);
    }
  }
}