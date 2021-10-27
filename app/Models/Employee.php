<?php

namespace App\Models;

use App\Database\Database;
use Error;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

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
    $this->role = $role;
  }

  public static function getAll(array $fileds = ['*'], string $where = null, string $order = null, string $limit = null): array
  {
    $result = (new Database('employees'))->select($fileds, $where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    return $result ? $result : [];
  }
  public static function getById(string $id, array $fileds = ['*']): ?Employee
  {
    $result = (new Database('employees'))->select($fileds, 'id = "' . $id . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public static function getByDocument(string $document, array $fileds = ['*']): ?Employee
  {
    $result = (new Database('employees'))->select($fileds, 'document = "' . $document . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public static function getCount(): int
  {
    return (int)(new Database('employees'))->select(['count(id) as total'])->fetchColumn(0);
  }
  public function store(): Employee
  {
    $this->setId(Uuid::uuid4());
    $this->setPassword(password_hash($this->getDocument(), PASSWORD_DEFAULT));

    try {
      (new Database('employees'))->insert([
        'id' => $this->getId(),
        'name' => $this->getName(),
        'document' => $this->getDocument(),
        'dateOfBirth' => $this->getDateOfBirth(),
        'email' => $this->getEmail(),
        'password' => $this->getPassword()
      ]);
    } catch (PDOException $e) {
      throw new Error('Não foi possível adicionar o funcionário');
    }

    return $this;
  }
  public function update(): Employee
  {
    // TODO implement here
    return $this;
  }
}
