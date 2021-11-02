<?php

namespace App\Models;

use App\Database\Database;
use Error;
use PDOException;
use Ramsey\Uuid\Uuid;

class Schedule
{
  const TABLE = 'schedules';

  private string $id;
  private Teacher $teacher;
  private SchoolClass $schoolClass;
  private Subject $subject;
  private string $startTime;
  private string $endTime;
  private int $dayOfTheWeek;

  public function getId(): string
  {
    return $this->id;
  }
  public function setId(string $id): void
  {
    $this->id = $id;
  }

  public function getTeacher(): Teacher
  {
    return $this->teacher;
  }
  public function setTeacher(Teacher $teacher): void
  {
    $this->teacher = $teacher;
  }

  public function getSchoolClass(): SchoolClass
  {
    return $this->schoolClass;
  }
  public function setSchoolClass(SchoolClass $schoolClass): void
  {
    $this->schoolClass = $schoolClass;
  }

  public function getSubject(): Subject
  {
    return $this->subject;
  }
  public function setSubject(Subject $subject): void
  {
    $this->subject = $subject;
  }

  public function getStartTime(): string
  {
    return $this->startTime;
  }
  public function setStartTime(string $startTime): void
  {
    $this->startTime = $startTime;
  }

  public function getEndTime(): string
  {
    return $this->endTime;
  }
  public function setEndTime(string $endTime): void
  {
    $this->endTime = $endTime;
  }

  public function getDayOfTheWeek(): int
  {
    return $this->dayOfTheWeek;
  }
  public function setDayOfTheWeek(int $dayOfTheWeek): void
  {
    $this->dayOfTheWeek = $dayOfTheWeek;
  }

  public function store(): Schedule
  {
    $this->id = Uuid::uuid4();

    try {
      $test = [
        'id' => $this->getId(),
        'idTeacher' => $this->getTeacher()->getId(),
        'idSchoolClass' => $this->getSchoolClass()->getId(),
        'idSubject' => $this->getSubject()->getId(),
        'startTime' => $this->getStartTime(),
        'endTime' => $this->getEndTime(),
        'dayOfTheWeek' => $this->getDayOfTheWeek()
      ];
      echo '<pre>';
      print_r($test);
      echo '</pre>';
      (new Database(self::TABLE))->insert([
        'id' => $this->getId(),
        'idTeacher' => $this->getTeacher()->getId(),
        'idSchoolClass' => $this->getSchoolClass()->getId(),
        'idSubject' => $this->getSubject()->getId(),
        'startTime' => $this->getStartTime(),
        'endTime' => $this->getEndTime(),
        'dayOfTheWeek' => $this->getDayOfTheWeek()
      ]);
    } catch (PDOException $e) {
      die($e);
      throw new Error('Não foi possível adicionar o horário');
    }
    return $this;
  }
}
