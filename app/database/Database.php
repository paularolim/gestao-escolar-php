<?php

namespace App\database;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
  const HOST = '0.0.0.0'; // localhost
  const DATABASE = 'gestao-escolar-php';
  const USER = 'root';
  const PASS = 'root123';

  private string $table;
  private PDO $connection;

  public function __construct($table = null)
  {
    $this->table = $table;
    $this->setConnection();
  }

  private function setConnection()
  {
    try {
      $driver = 'mysql:host=' . self::HOST . ';dbname=' . self::DATABASE . ';';
      $this->connection = new PDO($driver, self::USER, self::PASS);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die('[ERROR] ' . $e->getMessage());
    }
  }

  public function execute($query, $params = [])
  {
    try {
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    } catch (PDOException $e) {
      die('[ERROR] ' . $e->getMessage());
    }
  }

  public function insert(array $values): string
  {
    $fields = array_keys($values);
    $values = array_values($values);
    $binds = array_pad([], count($fields), '?');

    $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ');';

    $this->execute($query, $values);

    return $this->connection->lastInsertId();
  }

  public function select($fields = null, $where = null, $order = null, $limit = null): PDOStatement
  {
    $fields = is_array($fields) ? implode(',', $fields) : '*';
    $where = strlen($where) ? ' WHERE ' . $where : '';
    $order = strlen($order) ? ' ORDER BY ' . $order : '';
    $limit = strlen($limit) ? ' LIMIT ' . $limit : '';

    $query = 'SELECT ' . $fields . ' FROM ' . $this->table . $where . $order . $limit . ';';

    return $this->execute($query);
  }
}
