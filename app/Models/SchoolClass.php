<?php

namespace App\Models;

use App\Database\Database;
use Error;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

class SchoolClass
{
  const TABLE = 'schoolClasses';

  private string $id;
  private string $identifier;
  private int $year;
  private int $maxStudents;

  public function getId(): string
  {
    return $this->id;
  }

  public function getIdentifier(): string
  {
    return $this->identifier;
  }
  public function setIdentifier(string $identifier): void
  {
    $this->identifier = $identifier;
  }

  public function getYear(): int
  {
    return $this->year;
  }
  public function setYear(int $year): void
  {
    $this->year = $year;
  }

  public function getMaxStudents(): int
  {
    return $this->maxStudents;
  }
  public function setMaxStudents(int $maxStudents): void
  {
    $this->maxStudents = $maxStudents;
  }

  public static function getAll(array $fields = ['*'], string $where = null, string $order = null, string $limit = null): array
  {
    $result = (new Database(self::TABLE))->select($fields, $where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    return $result ? $result : [];
  }

  public static function getById(string $id, array $fields = ['*']): ?SchoolClass
  {
    $result = (new Database(self::TABLE))->select($fields, 'id = "' . $id . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }

  public function store(): SchoolClass
  {
    $this->id = Uuid::uuid4();
    try {
      (new Database(self::TABLE))->insert([
        'id' => $this->id,
        'identifier' => $this->identifier,
        'year' => $this->year,
        'maxStudents' => $this->maxStudents
      ]);
    } catch (PDOException $e) {
      die($e);
      throw new Error('Não foi possível adicionar a turma');
    }
    return $this;
  }

  public static function getStudents(string $id): array
  {
    $result = (new Database(''))->custom(
      'select s.id, s.name, s.document
      from matriculations m
      inner join students s
      where m.idStudent = s.id and m.idSchoolClass = "' . $id . '";'
    )->fetchAll(PDO::FETCH_ASSOC);

    return $result ? $result : [];
  }
}
