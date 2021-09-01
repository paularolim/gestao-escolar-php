<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Employee extends Person
{
  private static string $table = 'employees';

  public function __construct()
  {
  }

  public static function getByDocument(string $document)
  {
    return (new Database(self::$table))->select('*', 'document = "' . $document . '"')->fetchObject(self::class);
  }

  public static function getById(string $id)
  {
    return (new Database(self::$table))->select('*', 'document = "' . $id . '"')->fetchObject(self::class);
  }

  public static function getAll(array $fields = null, string $where = null, string $order = null, string $limit = null): array
  {
    return (new Database(self::$table))->select('name')->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function getCount(): int
  {
    return (int)(new Database(self::$table))->select(['count(id) as total'])->fetchColumn(0);
  }

  public function store(): string
  {
    return '';
  }
}
