<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Models\Employee;
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
        header('Location: /dashboard');
        exit;
      } else if ($type === 'teacher') {
      } else if ($type === 'student') {
      }
    } catch (Error $error) {
      die($error);
      return $view->render($response, 'Login/index.html', ['error' => true]);
    }
  }
}
