<?php

namespace App\Controllers;

use App\Config\Sessions\EmployeeSession;
use App\Config\Sessions\Session;
use App\Config\Sessions\TeacherSession;
use App\Models\SchoolClass;
use App\Utils\Pagination;
use App\Utils\Table;
use App\Utils\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SchoolClassController
{
  public static function getSchoolClasses(int $page = 1, int $size = 20): string
  {
    if (Session::whoIsLogged() === 'employee') {
      $totalClasses = SchoolClass::getCount();
      $pagination = new Pagination($page, $size, $totalClasses);

      $classes = SchoolClass::getAll(null, null, null, $pagination->limit());
    } else if (Session::whoIsLogged() === 'teacher') {
      $idTeacher = Session::getId();

      $pagination = new Pagination(1, 1, 1);
      $classes = SchoolClass::getAllFromTeacher($idTeacher);
      $totalClasses = count($classes);
    } else {
      $classes = [];
    }

    $table = new Table(
      ['Série', 'Turma', 'Ano', 'Ações'],
      ['number', 'identifier', 'year', 'button'],
      $classes,
      '/turmas'
    );

    $content = View::render('schoolClass/list', [
      'total' => $totalClasses,
      'table' => $table->render(),
      'pages' => $pagination->render('/turmas')
    ]);

    return LayoutController::getLayout('Turmas', $content);
  }

  public static function getSchoolClass(ServerRequestInterface $request, ResponseInterface $response, array $params)
  {
    $schoolClassId = $params['id'];
    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged() || TeacherSession::isLogged()) {
      $schoolClass = ['schoolClass' => (array)SchoolClass::getById($schoolClassId)];
      $students = ['students' => SchoolClass::getStudents($schoolClassId)];
      $totalStudents = ['totalStudents' => count($students['students'])];
      $schedules = ScheduleController::getSchedules($schoolClassId);

      $args = Session::getUser();
      $args = array_merge($args, $schoolClass, $totalStudents, $students, $schedules);

      return $view->render($response, 'SchoolClass/details.html', $args);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }

  public static function getAddSchoolClass()
  {
    $content = View::render('schoolClass/add');
    return LayoutController::getLayout('Turmas', $content);
  }

  public static function setAddSchoolClass(array $body)
  {
    $class = new SchoolClass();
    $class->number = $body['number'];
    $class->identifier = $body['identifier'];
    $class->year = $body['year'];
    $class->maxStudents = $body['maxStudents'];
    $class->store();

    header('Location: /turmas');
    exit;
  }
}
