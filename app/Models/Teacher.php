<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use PDOStatement;

class Teacher extends Person
{
  const TABLE = 'teachers';

  public string $formation;

  public function __construct(string $name, string $birthDate, string $document, string $email, string $formation)
  {
    parent::__construct($name, $birthDate, $document, $email);
    $this->formation = $formation;
  }

  final public static function getByDocument(string $document)
  {
    return (new Database(self::TABLE))->select('*', 'document = "' . $document . '"')->fetchAll(PDO::FETCH_CLASS);
  }

  public static function getById(string $id)
  {
    return (new Database(self::TABLE))->select('name, formation', 'id = "' . $id . '"')->fetchAll(PDO::FETCH_CLASS);
  }

  public static function getAll(array $fields = null, string $where = null, string $order = null, string $limit = null): array
  {
    $result = (new Database(self::TABLE))->select($fields, $where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    return $result ? $result : [];
  }

  public static function getCount(): int
  {
    return (int)(new Database(self::TABLE))->select(['count(id) as total'])->fetchColumn(0);
  }

  public function store(): string
  {
    $result = (new Database(self::TABLE))->insert([
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
