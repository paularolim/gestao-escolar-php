<?php

namespace App\Models;

use App\Database\Database;
use App\Models\Person;
use Error;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

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
    $this->formation = $formation;
  }

  public static function getAll(array $fileds = ['*'], string $where = null, string $order = null, string $limit = null): array
  {
    $result = (new Database('teachers'))->select($fileds, $where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    return $result ? $result : [];
  }
  public static function getById(string $id, array $fileds = ['*']): ?Teacher
  {
    $result = (new Database('teachers'))->select($fileds, 'id = "' . $id . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public static function getByDocument(string $document, array $fileds = ['*']): ?Teacher
  {
    $result = (new Database('teachers'))->select($fileds, 'document = "' . $document . '"')->fetchObject(self::class);
    return $result ? $result : null;
  }
  public static function getCount(): int
  {
    return (int)(new Database('teachers'))->select(['count(id) as total'])->fetchColumn(0);
  }
  public function store(): Teacher
  {
    $this->setId(Uuid::uuid4());
    $this->setPassword(password_hash($this->getDocument(), PASSWORD_DEFAULT));

    try {
      (new Database('teachers'))->insert([
        'id' => $this->getId(),
        'name' => $this->getName(),
        'document' => $this->getDocument(),
        'dateOfBirth' => $this->getDateOfBirth(),
        'email' => $this->getEmail(),
        'password' => $this->getPassword(),
        'formation' => $this->getFormation()
      ]);
    } catch (PDOException $e) {
      throw new Error('Não foi possível adicionar o funcionário');
    }

    return $this;
  }
  public function update(): Teacher
  {
    // TODO implement here
    return $this;
  }
}
