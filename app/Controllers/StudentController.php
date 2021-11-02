<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\Session;
use App\Config\Session\TeacherSession;
use App\Models\Matriculation;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
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
    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      $total = Student::getCount();
      $pagination = new Pagination($page, $size, $total);
      $pages = $pagination->getInfo();
      $students = Student::getAll(['id', 'name', 'document', 'active', 'matriculation'], null, 'name ASC', $pagination->limit());

      return $view->render($response, 'Student/list.html', [
        'user' => $user,
        'students' => $students,
        'total' => $total,
        'pages' => $pages
      ]);
    } else if (TeacherSession::isLogged()) {
      $students = Teacher::getStudents($user['id']);
      $total = count($students);
      $pagination = new Pagination(1, $total, $total);
      $pages = $pagination->getInfo();

      return $view->render($response, 'Student/list.html', [
        'user' => $user,
        'students' => $students,
        'total' => $total,
        'pages' => $pages
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function getStudent(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $id = $params['id'];
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    $student = Student::getById($id, ['id', 'name', 'document', 'phone', 'email', 'dateOfBirth', 'active', 'matriculation']);
    if ((EmployeeSession::isLogged() || TeacherSession::isLogged()) && !!$student) {
      $schoolClassesAvailable = SchoolClass::getAll(['*']);
      $schoolClasses = Student::getSchoolClasses($id);

      return $view->render($response, 'Student/details.html', [
        'user' => $user,
        'student' => $student,
        'schoolClassesAvailable' => $schoolClassesAvailable,
        'schoolClasses' => $schoolClasses
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

  public static function setAddSchoolClass(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $id = $params['id'];
    $body = $request->getParsedBody();
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    $matriculation = new Matriculation();
    $matriculation->setStudent(Student::getById($id));
    $matriculation->setSchoolClass(SchoolClass::getById($body['schoolClass']));

    try {
      $matriculation->store();
      header('Location: /alunos/' . $id);
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
