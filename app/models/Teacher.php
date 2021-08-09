<?php

namespace App\models;

use App\database\Database;
use PDO;

class Teacher extends Person
{  
  public string $formation;

  public function __construct(string $registry, string $name, string $birthDate, string $document, string $email, string $password, string $formation)
  {
    parent::__construct($registry, $name, $birthDate, $document, $email, $password);
    $this->formation = $formation;
  }

  public function store()
  {
    $database = new Database('teachers');
    $this->id = $database->insert([
      'id' => $this->id,
      'registry' => $this->registry,
      'name' => $this->name,
      'birthDate' => $this->birthDate,
      'document' => $this->document,
      'email' => $this->email,
      'password' => $this->password,
      'formation' => $this->formation,
    ]);

    return $this->id;
  }
}
