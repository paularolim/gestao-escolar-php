<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use PDOStatement;

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

  public static function getAll(): PDOStatement
  {
    return (new Database(self::$table))->select('name');
  }

  public function store(): string {
    return '';
  }
}
