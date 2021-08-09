<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestão Escolar - Professores</title>

  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
  <?php
  include __DIR__ . '/../components/header.php';
  require_once __DIR__ . '/../../helpers/dateFormat.php';
  ?>

  <div class="w3-container">
    <div class="w3-card-4 w3-margin-bottom">
      <header class="w3-container w3-light-grey">
        <h1><?= $teacher['name'] ?></h1>
      </header>

      <div class="w3-container">
        <p>Registro: <?= $teacher['registry'] ?></p>
        <p>Data de nascimento: <?= dateFormat($teacher['birthDate']) ?></p>
        <p>CPF: <?= $teacher['document'] ?></p>
        <p>Email: <?= $teacher['email'] ?></p>
        <p>Formação: <?= $teacher['formation'] ?></p>
      </div>

      <footer class="w3-container w3-light-grey w3-padding-16">
        <button class="w3-button w3-black">Editar</button>
        <button class="w3-button w3-black">Excluir</button>
      </footer>
    </div>

    <div class="w3-card-4 w3-margin-bottom">
      <header class="w3-container w3-light-grey">
        <h1>Matérias</h1>
      </header>

      <div class="w3-container">
        <p>Nenhuma matéria</p>
      </div>

      <footer class="w3-container w3-light-grey w3-padding-16">
        <button class="w3-button w3-black">Adicionar matéria</button>
      </footer>
    </div>

    <div class="w3-card-4 w3-margin-bottom">
      <header class="w3-container w3-light-grey">
        <h1>Turmas</h1>
      </header>

      <div class="w3-container">
        <p>Nenhuma turma</p>
      </div>

      <footer class="w3-container w3-light-grey w3-padding-16">
        <button class="w3-button w3-black">Adicionar turma</button>
      </footer>
    </div>
  </div>
</body>

</html>