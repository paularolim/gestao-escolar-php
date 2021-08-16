<?php

namespace App\Models;

use App\Database\Database;

class Teacher extends Person
{
  public string $formation;

  public function __construct()
  {
  }

  public static function getByDocument(string $document)
  {
    return (new Database('teachers'))->select('*', 'document = "' . $document . '"')->fetchObject(self::class);
  }

  public function store()
  {
  }
}
