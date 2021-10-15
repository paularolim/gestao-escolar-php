<?php

namespace App\Controllers;

use App\Config\Sessions\EmployeeSession;
use App\Config\Sessions\Session;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Utils\View;
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

  public static function setAddSchedule(string $idClass, array $body)
  {
    $schedule = new Schedule($body['startTime'], $body['endTime'], $body['dayOfTheWeek'], $idClass, $body['subject'], $body['teacher']);
    $schedule->store();

    header('Location: /turmas/' . $idClass);
    exit;
  }

  public static function getSchedules(string $idClass)
  {
    $schedules = Schedule::getAll($idClass);

    $generatedRows = self::generateRow($schedules);

    $rows = '';
    for ($i = 0; $i < count($generatedRows); $i++) {
      $rows .= View::render('schedule/table-tr', [
        'startTime' => $generatedRows[$i]['startTime'],
        'endTime' => $generatedRows[$i]['endTime'],

        'id0' => $generatedRows[$i][0]['id'],
        'subject0' => $generatedRows[$i][0]['subject'],
        'idTeacher0' => $generatedRows[$i][0]['idTeacher'],
        'teacher0' => $generatedRows[$i][0]['teacher'],

        'id1' => $generatedRows[$i][1]['id'],
        'subject1' => $generatedRows[$i][1]['subject'],
        'idTeacher1' => $generatedRows[$i][1]['idTeacher'],
        'teacher1' => $generatedRows[$i][1]['teacher'],

        'id2' => $generatedRows[$i][2]['id'],
        'subject2' => $generatedRows[$i][2]['subject'],
        'idTeacher2' => $generatedRows[$i][2]['idTeacher'],
        'teacher2' => $generatedRows[$i][2]['teacher'],

        'id3' => $generatedRows[$i][3]['id'],
        'subject3' => $generatedRows[$i][3]['subject'],
        'idTeacher3' => $generatedRows[$i][3]['idTeacher'],
        'teacher3' => $generatedRows[$i][3]['teacher'],

        'id4' => $generatedRows[$i][4]['id'],
        'subject4' => $generatedRows[$i][4]['subject'],
        'idTeacher4' => $generatedRows[$i][4]['idTeacher'],
        'teacher4' => $generatedRows[$i][4]['teacher'],

        'id5' => $generatedRows[$i][5]['id'],
        'subject5' => $generatedRows[$i][5]['subject'],
        'idTeacher5' => $generatedRows[$i][5]['idTeacher'],
        'teacher5' => $generatedRows[$i][5]['teacher'],

        'id6' => $generatedRows[$i][6]['id'],
        'subject6' => $generatedRows[$i][6]['subject'],
        'idTeacher6' => $generatedRows[$i][6]['idTeacher'],
        'teacher6' => $generatedRows[$i][6]['teacher']
      ]);
    }

    return View::render('schedule/table', ['rows' => $rows]);
  }

  public static function getSchedulesFromUser()
  {
    if (Session::whoIsLogged() !== 'teacher') {
      header('Location: /');
      exit;
    }

    $idTeacher = Session::getId();
    $schedules = Schedule::getAllFromTeacher($idTeacher);

    $generatedRows = self::generateRow($schedules);

    $rows = '';
    for ($i = 0; $i < count($generatedRows); $i++) {
      $rows .= View::render('schedule/table-tr', [
        'startTime' => $generatedRows[$i]['startTime'],
        'endTime' => $generatedRows[$i]['endTime'],

        'id0' => $generatedRows[$i][0]['id'],
        'subject0' => $generatedRows[$i][0]['subject'],
        'idTeacher0' => $generatedRows[$i][0]['idTeacher'],
        'teacher0' => $generatedRows[$i][0]['teacher'],

        'id1' => $generatedRows[$i][1]['id'],
        'subject1' => $generatedRows[$i][1]['subject'],
        'idTeacher1' => $generatedRows[$i][1]['idTeacher'],
        'teacher1' => $generatedRows[$i][1]['teacher'],

        'id2' => $generatedRows[$i][2]['id'],
        'subject2' => $generatedRows[$i][2]['subject'],
        'idTeacher2' => $generatedRows[$i][2]['idTeacher'],
        'teacher2' => $generatedRows[$i][2]['teacher'],

        'id3' => $generatedRows[$i][3]['id'],
        'subject3' => $generatedRows[$i][3]['subject'],
        'idTeacher3' => $generatedRows[$i][3]['idTeacher'],
        'teacher3' => $generatedRows[$i][3]['teacher'],

        'id4' => $generatedRows[$i][4]['id'],
        'subject4' => $generatedRows[$i][4]['subject'],
        'idTeacher4' => $generatedRows[$i][4]['idTeacher'],
        'teacher4' => $generatedRows[$i][4]['teacher'],

        'id5' => $generatedRows[$i][5]['id'],
        'subject5' => $generatedRows[$i][5]['subject'],
        'idTeacher5' => $generatedRows[$i][5]['idTeacher'],
        'teacher5' => $generatedRows[$i][5]['teacher'],

        'id6' => $generatedRows[$i][6]['id'],
        'subject6' => $generatedRows[$i][6]['subject'],
        'idTeacher6' => $generatedRows[$i][6]['idTeacher'],
        'teacher6' => $generatedRows[$i][6]['teacher']
      ]);
    }

    $view = View::render('schedule/table', ['rows' => $rows]);
    return LayoutController::getLayout('', $view);
  }

  private static function rowStructure($startTime, $endTime)
  {
    return [
      'startTime' => $startTime,
      'endTime' => $endTime,
      '0' => ['id' => '', 'subject' => '-', 'idTeacher' => '', 'teacher' => '-'],
      '1' => ['id' => '', 'subject' => '-', 'idTeacher' => '', 'teacher' => '-'],
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
