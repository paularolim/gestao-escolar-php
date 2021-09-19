<?php

namespace App\Models;

use App\Database\Database;
use Ramsey\Uuid\Uuid;

class Schedule
{
  public string $id;
  public string $startTime;
  public string $endTime;
  public int $dayOfTheWeek;
  public string $idClass;
  public string $idSubject;
  public string $idTeacher;

  const TABLE = 'schedules';

  public function __construct(string $startTime, string $endTime, int $dayOfTheWeek, string $idClass, string $idSubject, string $idTeacher)
  {
    $this->startTime = $startTime;
    $this->endTime = $endTime;
    $this->dayOfTheWeek = $dayOfTheWeek;
    $this->idClass = $idClass;
    $this->idSubject = $idSubject;
    $this->idTeacher = $idTeacher;
  }

  public function store(): string
  {
    $this->id = Uuid::uuid4();

    (new Database(self::TABLE))->insert((array)$this);

    return $this->id;
  }
}
