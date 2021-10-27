<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\StudentSession;
use App\Config\Session\TeacherSession;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Teacher;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class LoginController
{
  public static function getLoginScreen(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    return $view->render($response, 'Login/index.html', []);
  }

  public static function setLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    $body = $request->getParsedBody();
    $type = $body['type'];
    $document = $body['document'];
    $password = $body['password'];

    try {
      if ($type === 'employee') {
        $employee = Employee::getByDocument($document);
        if (!$employee instanceof Employee) {
          throw new Error('User does not exists');
        }
        if (!password_verify($password, $employee->getPassword())) {
          throw new Error('Incorrect password');
        }

        EmployeeSession::login($employee);
      } else if ($type === 'teacher') {
        $teacher = Teacher::getByDocument($document);
        if (!$teacher instanceof Teacher) {
          throw new Error('User does not exists');
        }
        if (!password_verify($password, $teacher->getPassword())) {
          throw new Error('Incorrect password');
        }

        TeacherSession::login($teacher);
      } else if ($type === 'student') {
        $student = Student::getByDocument($document);
        if (!$student instanceof Student) {
          throw new Error('User does not exists');
        }
        if (!password_verify($password, $student->getPassword())) {
          throw new Error('Incorrect password');
        }

        StudentSession::login($student);
      }

      header('Location: /dashboard');
      exit;
    } catch (Error $error) {
      return $view->render($response, 'Login/index.html', ['error' => true]);
    }
  }
}
