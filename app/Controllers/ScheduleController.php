<?php

namespace App\Controllers;

use App\Config\Sessions\EmployeeSession;
use App\Config\Sessions\Session;
use App\Config\Sessions\TeacherSession;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ScheduleController
{
  public static function getAddSchedule(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $idClass = $args['idClass'];

    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $students = SchoolClass::getStudents($idClass);
      $schoolClass = ['schoolClass' => (array)SchoolClass::getById($idClass)];
      $totalStudents = ['totalStudents' => count($students)];
      $subjects = ['subjects' => Subject::getAll(['id', 'name', 'workload'], null, 'name ASC')];
      $teachers = ['teachers' => Teacher::getAll(['id', 'name', 'document', 'formation'], null, 'name ASC')];

      $args = Session::getUser();
      $args = array_merge($args, $schoolClass, $totalStudents, $subjects, $teachers);

      return $view->render($response, 'Schedule/add.html', $args);
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }

  public static function setAddSchedule(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
  {
    $idClass = $params['idClass'];
    $body = $request->getParsedBody();

    $view = Twig::fromRequest($request);

    if (EmployeeSession::isLogged()) {
      $schedule = new Schedule(
        $body['startTime'],
        $body['endTime'],
        $body['dayOfTheWeek'],
        $idClass,
        $body['subject'],
        $body['teacher']
      );

      try {
        $schedule->store();

        header('Location: /turmas/' . $idClass);
        exit;
      } catch (Error $error) {

        $error = ['error' => 'Não foi possível adicionar este horário'];

        $args = Session::getUser();
        $args = array_merge($args, $error);

        return $view->render($response, 'Schedule/add.html', $args);
      }
    } else {
      return $view->render($response, 'Error/not-found.html');
    }
  }

  public static function getSchedules(string $schoolClassId): array
  {
    $schedules = Schedule::getAll($schoolClassId);

    $generatedRows = ['schedules' => self::generateRow($schedules)];
    return $generatedRows;
  }

  public static function getSchedulesFromUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $view = Twig::fromRequest($request);

    if (TeacherSession::isLogged()) {
      $idTeacher = Session::getId();
      $schedules = Schedule::getAllFromTeacher($idTeacher);


      $generatedRows = ['rows' => self::generateRow($schedules)];

      $args = Session::getUser();
      $args = array_merge($args, $generatedRows);

      return $view->render($response, 'Schedule/schedule.html', $args);
    } else {
      return $view->render($response, 'Error/not-found.html');
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
        'subject' => $schedule['subject'],
        'idTeacher' => $schedule['idTeacher'],
        'teacher' => $schedule['teacher']
      ];
    }

    return array_values($row);
  }
}
