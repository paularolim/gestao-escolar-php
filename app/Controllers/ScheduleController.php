<?php

namespace App\Controllers;

use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Utils\View;

class ScheduleController
{
  public static function getAddSchedule(string $idClass)
  {
    $class = SchoolClass::getById($idClass);
    $students = SchoolClass::getStudents($idClass);
    $subjects = Subject::getAll(['id', 'name', 'workload']);
    $teachers = Teacher::getAll(['id', 'name', 'document', 'formation']);

    $optionSubject = '';
    foreach ($subjects as $subject) {
      $optionSubject .= View::render('schedule/select-option', [
        'id' => $subject['id'],
        'title' => $subject['name'] . ' - ' . $subject['workload'] . ' hrs'
      ]);
    }

    $optionsTeacher = '';
    foreach ($teachers as $teacher) {
      $optionsTeacher .= View::render('schedule/select-option', [
        'id' => $teacher['id'],
        'title' => $teacher['name'] . ' (' . $teacher['document'] . ') - ' . $teacher['formation']
      ]);
    }

    $content = View::render('schedule/edit', [
      'id' => $class->id,
      'number' => $class->number,
      'identifier' => $class->identifier,
      'maxStudents' => $class->maxStudents,
      'totalStudents' => count($students),
      'optionsSubject' => $optionSubject,
      'optionsTeacher' => $optionsTeacher
    ]);
    return LayoutController::getLayout('Horários', $content);
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
