<?php

namespace App\Models;

use App\Database\Database;
use Error;
use PDOException;
use Ramsey\Uuid\Uuid;

class Matriculation
{
  const TABLE = 'matriculations';

  private string $id;
  private Student $student;
  private SchoolClass $schoolClass;
  private string $date;
  private string $status = 'studying';

  public function __construct()
  {
    $this->id = Uuid::uuid4();
    $this->date = date('Y-m-d');
  }

  public function setId(string $id): void
  {
    $this->id = $id;
  }
  public function getId(): string
  {
    return $this->id;
  }

  public function setStudent(Student $student): void
  {
    $this->student = $student;
  }
  public function getStudent(): Student
  {
    return $this->student;
  }

  public function setSchoolClass(SchoolClass $schoolClass): void
  {
    $this->schoolClass = $schoolClass;
  }
  public function getSchoolClass(): SchoolClass
  {
    return $this->schoolClass;
  }

  public function setDate(string $date): void
  {
    $this->date = $date;
  }
  public function getDate(): string
  {
    return $this->date;
  }

  public function setStatus(string $status): void
  {
    $this->status = $status;
  }
  public function getStatus(): string
  {
    return $this->status;
  }

  public function store(): Matriculation
  {
    try {
      (new Database(self::TABLE))->insert([
        'id' => $this->id,
        'idStudent' => $this->student->getId(),
        'idSchoolClass' => $this->schoolClass->getId(),
        'date' => $this->date,
        'status' => $this->status
      ]);
    } catch (PDOException $e) {
      die($e);
      throw new Error('Não foi possível adicionar a matricula');
    }
    return $this;
  }
}
