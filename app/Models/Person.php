<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use Ramsey\Uuid\Uuid;

abstract class Person
{
  public string $id;
  public string $registry;
  public string $name;
  public string $birthDate;
  public string $document;
  public string $email;
  public string $password;

  public function __construct(string $registry, string $name, string $birthDate, string $document, string $email, string $password)
  {
    $this->id = Uuid::uuid4();
    $this->registry = $registry;
    $this->name = $name;
    $this->birthDate = $birthDate;
    $this->document = $document;
    $this->email = $email;
    $this->password = $password;
  }

  public abstract static function getByDocument(string $document);

  public function login(): void
  {
  }

  public function logout(): void
  {
  }
}
