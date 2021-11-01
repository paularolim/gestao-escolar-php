<?php

namespace App\Controllers;

use App\Config\Session\Session;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Teacher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ProfileController
{
  public static function getProfileScreen(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);
    $userSession = Session::getUser();

    if ($userSession['type'] == 'employee') {
      $userSearch = Employee::getById($userSession['id'], ['id', 'name', 'document', 'dateOfBirth', 'phone', 'email', 'role']);
    } else if ($userSession['type'] == 'teacher') {
      $userSearch = Teacher::getById($userSession['id'], ['id', 'name', 'document', 'dateOfBirth', 'phone', 'email', 'formation']);
    } else if ($userSession['type'] == 'student') {
      $userSearch = Student::getById($userSession['id'], ['id', 'name', 'document', 'dateOfBirth', 'phone', 'email', 'matriculation']);
    }

    $user = [
      'type' => $userSession['type'],
      'id' => $userSearch->getId(),
      'name' => $userSearch->getName(),
      'document' => $userSearch->getDocument(),
      'dateOfBirth' => $userSearch->getDateOfBirth(),
      'phone' => $userSearch->getPhone(),
      'email' => $userSearch->getEmail(),
      'active' => $userSearch->getActive(),
    ];

    if ($userSearch instanceof Employee) $user['role'] = $userSearch->getRole();
    else if ($userSearch instanceof Teacher) $user['formation'] = $userSearch->getFormation();
    else if ($userSearch instanceof Student) $user['matriculation'] = $userSearch->getMatriculation();

    return $view->render($response, 'Profile/index.html', [
      'user' => $user
    ]);
  }
}
