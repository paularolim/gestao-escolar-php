<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use Ramsey\Uuid\Uuid;

class SchoolClass
{
  public string $id;
  public int $number;
  public string $identifier;
  public int $year;

  const TABLE = 'classes';

  public function __construct()
  {
  }

  public static function getById(string $id, array $fields = null): SchoolClass
  {
    return (new Database(self::TABLE))->select($fields, 'id = "' . $id . '"')->fetchObject(self::class);
  }

  public static function getAll(array $fields = null, string $where = null, string $order = null, string $limit = null): array
  {
    $result = (new Database(self::TABLE))->select($fields, $where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    return $result ? $result : [];
  }

  public static function getCount(): int
  {
    return (int)(new Database(self::TABLE))->select(['count(id) as total'])->fetchColumn(0);
  }

  public function store(): string
  {
    $this->id = Uuid::uuid4();

    (new Database(self::TABLE))->insert((array)$this);

    return $this->id;
  }
}
