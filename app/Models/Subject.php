<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use Ramsey\Uuid\Uuid;

class Subject
{
  const TABLE = 'subjects';

  public string $id;
  public string $name;
  public int $workload;

  public static function getAll(array $fields = null, string $where = null, string $order = null, string $limit = null): array
  {
    return (new Database(self::TABLE))->select($fields, $where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function getById(string $id, array $fields = null): Subject
  {
    return (new Database(self::TABLE))->select($fields, 'id = "' . $id . '"')->fetchObject(self::class);
  }

  public static function getCount(): int
  {
    return (int)(new Database(self::TABLE))->select(['count(id) as total'])->fetchColumn(0);
  }

  public function store(): Subject
  {
    $this->id = Uuid::uuid4();

    (new Database(self::TABLE))->insert((array) $this);

    return $this;
  }
}
