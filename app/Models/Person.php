<?php

namespace App\Models;

use PDOStatement;
use Ramsey\Uuid\Uuid;

abstract class Person
{
  public string $id;
  public string $name;
  public string $birthDate;
  public string $document;
  public string $email;
  public string $password;

  public function __construct(string $name, string $birthDate, string $document, string $email, string $password)
  {
    $this->id = Uuid::uuid4();
    $this->name = $name;
    $this->birthDate = $birthDate;
    $this->document = $document;
    $this->email = $email;
    $this->password = $password;
  }

  public abstract static function getByDocument(string $document);
  public abstract static function getAll(): PDOStatement;
}
