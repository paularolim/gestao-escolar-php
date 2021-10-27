<?php

namespace App\Models;

use App\Database\Database;

class Employee extends Person
{
  private string $role;

  public function __construct()
  {
  }

  public function getRole(): string
  {
    return $this->role;
  }
  public function setRole(string $role): void
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

  public static function getAll(array $fileds = ['*'], string $where, string $order, string $limit): array
  {
    // TODO implement here
    return [];
  }
  public static function getById(string $id, array $fileds = ['*']): ?Employee
  {
    // TODO implement here
    return new Employee();
  }
  public static function getByDocument(string $document, array $fileds = ['*']): ?Employee
  {
    $result = (new Database('employees'))->select($fileds, 'document = "' . $document . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public function store(): Employee
  {
    // TODO implement here
    return $this;
  }
  public function update(): Employee
  {
    // TODO implement here
    return $this;
  }
}
