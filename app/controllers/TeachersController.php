<?php


namespace App\controllers;

use App\database\Database;
use App\models\Teacher;
use PDO;

class TeachersController
{
  const TABLE = 'teachers';

  public function getAll()
  {
    $teachers = (new Database(self::TABLE))->select(
      ['id', 'registry', 'name', 'birthDate', 'document', 'formation']
    )->fetchAll(PDO::FETCH_ASSOC);

    include __DIR__ . '/../views/teachers/list.php';
    exit;
  }
  
  public function getById(string $id)
  {
    $teacher = (new Database(self::TABLE))
      ->select(
        ['registry', 'name', 'birthDate', 'document', 'email', 'formation'],
        'id = "' . $id . '"'
      )
      ->fetch(PDO::FETCH_ASSOC);

    include __DIR__ . '/../views/teachers/profile.php';
    exit;
  }
  public function create()
  {
    if (isset($_POST['name'], $_POST['birthDate'], $_POST['document'], $_POST['email'], $_POST['formation'])) {
      $teacher = new Teacher('123', $_POST['name'], $_POST['birthDate'], $_POST['document'], $_POST['email'], $_POST['document'], $_POST['formation']);
      $teacher->store();

      header('Location: ' . $_SERVER['HTTP_HOST'] . '/professores');
    }

    include __DIR__ . '/../views/teachers/create.php';
    exit;
  }
  public function update()
  {
  }
  public function delete()
  {
  }
}
