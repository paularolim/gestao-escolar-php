<?php

namespace App\Models;

abstract class Person
{
  protected string $id;
  protected string $name;
  protected string $document;
  protected string $dateOfBirth;
  protected string $phone;
  protected string $email;
  protected string $password;
  protected bool $active = true;

  protected function __construct()
  {
    // ...
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }
  public function setName(string $name): void
  {
    // TODO implement here
  }

  public function getDocument(): string
  {
    return $this->document;
  }
  public function setDocument(string $document): void
  {
    // TODO implement here
  }

  public function getDateOfBirth(): string
  {
    return $this->dateOfBirth;
  }
  public function setDateOfBirth(string $dateOfBirth)
  {
    // TODO implement here
  }

  public function getPhone(): string
  {
    return $this->phone;
  }
  public function setPhone(string $phone)
  {
    // TODO implement here
  }

  public function getEmail(): string
  {
    return $this->email;
  }
  public function setEmail(string $email)
  {
    // TODO implement here
  }

  public function getPassword(): string
  {
    return $this->password;
  }
  public function setPassword(string $password)
  {
    // TODO implement here
  }

  public function getActive(): bool
  {
    return $this->active;
  }
  public function changeActive(): bool
  {
    $this->active = !$this->active;
    return $this->active;
  }

  protected static abstract function login(string $email,  string $password): bool;
  protected static abstract function logout(): bool;

  protected static abstract function getAll(array $fileds = ['*'], string $where, string $order, string $limit): array;
  protected static abstract function getById(string $id, array $fileds = ['*']): ?Person;
  protected static abstract function getByDocument(string $document, array $fileds = ['*']): ?Person;
  protected abstract function store(): Person;
  protected abstract function update(): Person;
}
