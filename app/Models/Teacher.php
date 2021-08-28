<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use PDOStatement;

class Teacher extends Person
{
  private static string $table = 'teachers';

  public string $formation;

  public function __construct(string $name, string $birthDate, string $document, string $email, string $formation)
  {
    parent::__construct($name, $birthDate, $document, $email);
    $this->formation = $formation;
  }

  public static function getByDocument(string $document)
  {
    return (new Database(self::$table))->select('*', 'document = "' . $document . '"')->fetchObject(self::class);
  }

  public static function getAll(): array
  {
    return (new Database(self::$table))->select('name, formation')->fetchAll(PDO::FETCH_ASSOC);
  }

  public function store(): string
  {
    
    $result = (new Database(self::$table))->insert([
      'id' => $this->id,
      'name' => $this->name,
      'birthDate' => $this->birthDate,
      'document' => $this->document,
      'email' => $this->email,
      'password' => $this->password,
      'formation' => $this->formation
    ]);

    return '';
  }
}
