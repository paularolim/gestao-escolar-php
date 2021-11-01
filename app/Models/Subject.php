<?php

namespace App\Models;

use App\Database\Database;
use Error;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

class Subject
{
  const TABLE = 'subjects';

  private String $id;
  private String $title;
  private int $workload;
  private float $passingScore;
  public array $schoolClasses;
  public array $subjects;
  public array $Evaluations;
  public array $Teacher;
  public array $Subject;

  public function __construct()
  {
    $this->id = Uuid::uuid4();
  }

  public function getId(): String
  {
    return $this->id;
  }

  public function getTitle(): String
  {
    return $this->title;
  }
  public function setTitle(String $title): void
  {
    $this->title = $title;
  }

  public function getWorkload(): int
  {
    return $this->workload;
  }
  public function setWorkload(int $workload): void
  {
    $this->workload = $workload;
  }

  public function getPassingScore(): float
  {
    return $this->passingScore;
  }
  public function setPassingScore(float $passingScore): void
  {
    $this->passingScore = $passingScore;
  }

  public function store(): Subject
  {
    try {
      (new Database(self::TABLE))->insert([
        'id' => $this->getId(),
        'title' => $this->getTitle(),
        'workload' => $this->getWorkload(),
        'passingScore' => $this->getPassingScore()
      ]);
    } catch (PDOException $e) {
      throw new Error('Não foi possível adicionar a matéria');
    }

    return $this;
  }

  public function update(): Subject
  {
    // TODO implement udate subject
    return new Subject;
  }

  public static function getAll(array $fields = ['*'], string $where = null, string $order = null, string $limit = null): array
  {
    $result = (new Database(self::TABLE))->select($fields, $where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    return $result ? $result : [];
  }

  public static function getById(string $id, array $fields = ['*']): ?Subject
  {
    $result = (new Database(self::TABLE))->select($fields, 'id = "' . $id . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
}
