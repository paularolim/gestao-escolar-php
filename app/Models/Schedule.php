<?php

namespace App\Models;

use App\Database\Database;
use PDO;
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

  public static function getAll(string $idClass)
  {
    return (new Database(self::TABLE))->custom('select sch.id, sub.name as subject, sch.idTeacher, t.name as teacher, sch.dayOfTheWeek, sch.startTime, sch.endTime
    from schedules sch
    inner join subjects sub, teachers t
    where sch.idClass = "' . $idClass . '" and sch.idSubject = sub.id and sch.idTeacher = t.id
    order by sch.startTime')->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function getAllFromTeacher(string $idTeacher)
  {
    return (new Database(self::TABLE))->custom('
    select s.id, s.idSubject, s.idTeacher, s.idClass, s.dayOfTheWeek, s.startTime, s.endTime, su.name as subject
    from schedules s
    inner join teachers t, subjects su
    where s.idTeacher = t.id and s.idSubject = su.id and t.id = "' . $idTeacher . '"
    ')->fetchAll(PDO::FETCH_ASSOC);
  }

  public function store(): string
  {
    $this->id = Uuid::uuid4();

    (new Database(self::TABLE))->insert((array)$this);

    return $this->id;
  }
}
