<?php
session_start();
require("../sistema_bd.php");
protectAdm();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<header>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Principal</title>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <link rel="stylesheet" href="../css/main.css" />
</header>
<div id="header">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a href="<?php echo (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) ? 'indexAdmin.php' : 'index.php'; ?>"><img src="../assets/logo.svg" class="navbar-brand img-fluid" height="200" width="200" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="../pontosCulturais.php">Pontos Culturais</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../eventos.php">Eventos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../comunidade.php">Comunidade</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../comunidade.php"></a>
          </li>
        </ul>
      </div>
    </nav>
    <a class="legend" href="../perfil.php"><small style="font-size: 15px; position: absolute; left: -39px; top: 5px;">Perfil</small>
      <i class="login">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
          <path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
          <path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
        </svg>
      </i>
    </a>
  </div>
</div>

<body style="background-color: #ede1d8;">
  <section class="container">
    <div class="container-login editSelect">
      <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
      <p>
        <?php
        include("../util/mensagens.php");
        include("../util/tempoMsg.php");
        ?>
      </p>
    </div>
    </br></br>
    <?php if (isset($_SESSION["usuario_logado"])) { ?>
      <p class="header" style="text-transform: uppercase; font-weight: 700; padding: 0px 0px 5px 0px; margin-top: -15px; text-align: center; margin-top: 20%; color: #915c37; text-decoration: none; border-bottom: solid 4px transparent; font-size: 44px;">Seja Bem-Vindo ADM!</p>
    <?php } ?>
  </section>
</body>

</html>