<?php

namespace App\Models;

use App\Database\Database;
use App\Models\Person;

class Teacher extends Person
{
  private string $formation;

  public function __construct()
  {
  }

  public function getFormation(): string
  {
    return $this->formation;
  }
  public function setFormation(string $formation): void
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
  public static function getById(string $id, array $fileds = ['*']): ?Teacher
  {
    // TODO implement here
    return new Teacher();
  }
  public static function getByDocument(string $document, array $fileds = ['*']): ?Teacher
  {
    $result = (new Database('teachers'))->select($fileds, 'document = "' . $document . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public function store(): Teacher
  {
    // TODO implement here
    return $this;
  }
  public function update(): Teacher
  {
    // TODO implement here
    return $this;
  }
}
