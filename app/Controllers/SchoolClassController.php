<?php

namespace App\Controllers;

use App\Config\Session\EmployeeSession;
use App\Config\Session\Session;
use App\Config\Session\TeacherSession;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
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
    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      $total = SchoolClass::getAll(['count(*) as total'])[0]['total'];
      $pagination = new Pagination($page, $size, $total);
      $pages = $pagination->getInfo();
      $schoolClasses = SchoolClass::getAll();

      return $view->render($response, 'SchoolClass/list.html', [
        'user' => $user,
        'schoolClasses' => $schoolClasses,
        'total' => $total,
        'pages' => $pages
      ]);
    } else if (TeacherSession::isLogged()) {
      $schoolClasses = Teacher::getSchoolClasses($user['id']);
      $total = count($schoolClasses);
      $pagination = new Pagination(1, $total, $total);
      $pages = $pagination->getInfo();

      return $view->render($response, 'SchoolClass/list.html', [
        'user' => $user,
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
    if ((EmployeeSession::isLogged() || TeacherSession::isLogged()) && !!$schoolClass) {
      $students = SchoolClass::getStudents($id);
      $total = count($students);
      $schedules = SchoolClass::getSchedules($id);
      $schedulesRows = self::generateRow($schedules);

      return $view->render($response, 'SchoolClass/details.html', [
        'user' => $user,
        'schoolClass' => $schoolClass,
        'total' => $total,
        'students' => $students,
        'schedules' => $schedulesRows
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

  public static function getAddSchedule(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args['id'];
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    if (EmployeeSession::isLogged()) {
      $subjects = Subject::getAll();
      $teachers = Teacher::getAll();
      $schoolClass = SchoolClass::getById($id);

      return $view->render($response, 'SchoolClass/add-schedule.html', [
        'user' => $user,
        'schoolClass' => $schoolClass,
        'subjects' => $subjects,
        'teachers' => $teachers
      ]);
    }

    return $view->render($response, 'Error/not-found.html', [
      'user' => $user
    ]);
  }

  public static function setAddSchedule(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args['id'];
    $body = $request->getParsedBody();
    $view = Twig::fromRequest($request);
    $user = Session::getUser();

    $schedule = new Schedule();
    $schedule->setTeacher(Teacher::getById($body['teacher']));
    $schedule->setSchoolClass(SchoolClass::getById($id));
    $schedule->setSubject(Subject::getById($body['subject']));
    $schedule->setStartTime($body['startTime']);
    $schedule->setEndTime($body['endTime']);
    $schedule->setDayOfTheWeek($body['dayOfTheWeek']);

    try {
      $schedule->store();
      header('Location: /turmas/' . $id);
      exit;
    } catch (Error $e) {
      die($e);
      return $view->render($response, 'SchoolClass/add-schedule.html', [
        'user' => $user,
        'error' => true
      ]);
    }
  }

  private static function rowStructure($startTime, $endTime)
  {
    return [
      'startTime' => $startTime,
      'endTime' => $endTime,
      '0' => '-',
      '1' => '-',
      '2' => '-',
      '3' => '-',
      '4' => '-',
      '5' => '-',
      '6' => '-',
    ];
  }

  private static function generateRow(array $schedules): array
  {
    $row = [];

    foreach ($schedules as $schedule) {
      $row[$schedule['startTime']] = self::rowStructure($schedule['startTime'], $schedule['endTime']);
    }
    foreach ($schedules as $schedule) {
      $row[$schedule['startTime']][($schedule['dayOfTheWeek'])] = [
        'id' => $schedule['id'],
        'idSchoolClass' => $schedule['idSchoolClass'],
        'idSubject' => $schedule['idSubject'],
        'subject' => $schedule['title'],
        'idTeacher' => $schedule['idTeacher'],
        'teacher' => $schedule['name']
      ];
    }

    return array_values($row);
  }
}
