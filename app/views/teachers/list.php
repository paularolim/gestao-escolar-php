  <?php

  require_once __DIR__ . '/../../helpers/dateFormat.php';

  $rows = '';
  foreach ($teachers as $teacher) {
    $rows .= '
    <tr>
    <td>' . $teacher['registry'] . '</td>
    <td>' . $teacher['name'] . '</td>
    <td>' . dateFormat($teacher['birthDate']) . '</td>
    <td>' . $teacher['document'] . '</td>
    <td>' . $teacher['formation'] . '</td>
    <td>
    <a href="/professores/' . $teacher['id'] . '" class="w3-button w3-green"><i class="fas fa-user"></i></a>
    </td>
    </tr>';
  }
  ?>

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
    ?>

    <div class="w3-container">
      <a href="/professores/adicionar" class="w3-button w3-green w3-margin-bottom">Adicionar Professor</a>

      <table class="w3-table w3-striped">
        <thead>
          <tr class="w3-blue">
            <th>Registro</th>
            <th>Nome</th>
            <th>Data de nascimento</th>
            <th>CPF</th>
            <th>Formação</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?= $rows ?>
        </tbody>
      </table>

      <div class="w3-bar w3-margin-top">
        <a href="#" class="w3-button">&laquo;</a>
        <a href="#" class="w3-button w3-blue">1</a>
        <a href="#" class="w3-button">2</a>
        <a href="#" class="w3-button">3</a>
        <a href="#" class="w3-button">4</a>
        <a href="#" class="w3-button">5</a>
        <a href="#" class="w3-button">&raquo;</a>
      </div>
    </div>
  </body>

  </html>