<?php

namespace App\models;

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
  }
}
