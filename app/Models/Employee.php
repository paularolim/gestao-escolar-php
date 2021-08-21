<?php

namespace App\Models;

use App\Database\Database;

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
}
