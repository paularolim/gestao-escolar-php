<?php

namespace App\Models;

use App\Database\Database;

class Employee extends Person
{
  public function __construct()
  {
  }

  public static function getByDocument(string $document)
  {
    return (new Database('employees'))->select('*', 'document = "' . $document . '"')->fetchObject(self::class);
  }

  public function store()
  {
  }
}
