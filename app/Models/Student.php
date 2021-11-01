<?php

namespace App\Models;

use App\Database\Database;

class Student extends Person
{
  private string $matriculation;

  public function __construct()
  {
  }

  public function getMatriculation(): string
  {
    return $this->matriculation;
  }
  public function setMatriculation(string $matriculation): void
  {
    // TODO implement here
  }

  public static function login(string $email,  string $password): bool
  {
    // TODO implement here
    return true;
  }
  public static function logout(): bool
  {
    // TODO implement here
    return true;
  }

  public static function getAll(array $fileds = ['*'], string $where = null, string $order = null, string $limit = null): array
  {
    // TODO implement here
    return [];
  }
  public static function getById(string $id, array $fileds = ['*']): ?Student
  {
    $result = (new Database('students'))->select($fileds, 'id = "' . $id . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public static function getByDocument(string $document, array $fileds = ['*']): ?Student
  {
    $result = (new Database('students'))->select($fileds, 'document = "' . $document . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public function store(): Student
  {
    // TODO implement here
    return $this;
  }
  public function update(): Student
  {
    // TODO implement here
    return $this;
  }
}
