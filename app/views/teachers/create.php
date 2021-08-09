<?php

// use App\models\Teacher;

// if (isset($_POST['name'], $_POST['birthDate'], $_POST['document'], $_POST['email'], $_POST['formation'])) {
//   $teacher = new Teacher('123', $_POST['name'], $_POST['birthDate'], $_POST['document'], $_POST['email'], $_POST['document'], $_POST['formation']);
//   $teacher->store();

//   header('Location: ' . $_SERVER['HTTP_HOST'] . '/professores');
//   exit;
// }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestão Escolar - Professores</title>

  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
  <?php include __DIR__ . '/../components/header.php' ?>

  <form class="w3-container" method="POST">
    <label class="w3-text-blue">Name</label>
    <input class="w3-input w3-border" type="text" name="name">

    <label class="w3-text-blue">Data de nascimento</label>
    <input class="w3-input w3-border" type="date" name="birthDate">

    <label class="w3-text-blue">CPF</label>
    <input class="w3-input w3-border" type="text" name="document">

    <label class="w3-text-blue">Email</label>
    <input class="w3-input w3-border" type="email" name="email">

    <label class="w3-text-blue">Formação</label>
    <input class="w3-input w3-border" type="text" name="formation">

    <button type="submit" class="w3-btn w3-green w3-margin-top">Adicionar</button>
  </form>
</body>

</html>