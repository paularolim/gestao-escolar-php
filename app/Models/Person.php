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

  public function __construct(string $name, string $birthDate, string $document, string $email)
  {
    $this->id = Uuid::uuid4();
    $this->name = $name;
    $this->birthDate = $birthDate;
    $this->document = $document;
    $this->email = $email;
    $this->password = password_hash($document, PASSWORD_DEFAULT);
  }

  public abstract static function getByDocument(string $document);
  public abstract static function getById(string $id);
  public abstract static function getAll(): array;
  public abstract function store(): string;
}
