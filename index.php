<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
    $email = $_SESSION['usuario_logado'];
    buscarNomeUser($email);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="css/main.css" />
<title>Início - ARQ Cultura</title>
<style>
    .bodyBusca {
        color: #fff;
    }

    .container {
        margin-top: 10px;
        left: 10px;
    }

    .search-box {
        width: 228px;
        padding: 11px;
        border: none;
        border-radius: 7px;
        font-size: 13px;
        margin-left: 80px;
        background-color: #d3beaf;
    }

    .search-button {
        background-color: #915C37;
        color: #fff;
        border: none;
        border-radius: 7px;
        padding: 14px 10px;
        font-size: 13px;
        cursor: pointer;
    }

    .ativado {
        color: #915c37 !important;
        font-weight: bolder !important;
        border-bottom: solid 4px var(--primary) !important;
    }
</style>
<div id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <img src="assets/logo.svg" class="navbar-brand img-fluid" height="200" width="200" />
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link ativado" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pontosCulturais.php">Pontos Culturais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="eventos.php">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comunidade.php">Comunidades</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
                            $nome_usuario = $_SESSION['nome_user'];
                            echo '<a class="legend" href="perfil2.php"><h1 class="legend" style="font-size: 16px; position: absolute; right: -76px; top: 2px; font-weight: normal;">' . $nome_usuario . '</h1><i class="perfil" style="position: absolute; right: -50px; top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></i></a>';
                        } else {
                            echo '<a class="legend" href="login.php"><p class="legend" style="font-size: 16px; position: absolute; right: -76px; top: 2px;">Entrar</p><i class="perfil" style="position: absolute; right: -68px; top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></i></a>';
                        } ?>
                    </li>
                    <li class="nav-item">
                        <a class="legend" href="duvidas.php"><small style="font-size: 15.4px; position: absolute; right: -130px; top: 3px;">Ajuda</small>
                            <i class="bi bi-question-circle" style="position: absolute; right: -122px; top: -45.5px; font-size: 39px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                                </svg>
                            </i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<body>
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 align-self mb-md-0 mb-4 intro">
                <h1>Sistema: ARQ Cultura</h1>
                <h4 class="mb-4">Permite a divulgação de atividades culturais na cidade de Araraquara.</h4>
                <a href="#sobre" class="btn button-secondary btn-secondary button d-md-inline-block d-block mb-md-0 mb-2 mr-md-2">Saiba mais</a>
            </div>
            <div class="col-lg-8 col-md-6">
                <form method="get" action="buscaTudo.php">
                    <input type="text" class="search-box" name="palavraChave" id="palavraChave" placeholder="Digite uma palavra-chave" style="color: #fff; margin-left: 626px; position: relative; margin-top: -141px;" required>
                    <button type="submit" class="search-button" style="margin-left: 755px; margin-top: 53px;">Pesquisar</button>
                    <div clas="radioBusca" style="margin-left: 518px; margin-top: 6px; font-size: 14px;">
                        <input type="radio" id="pontos" name="busca" value="pontos" required>
                        <label for="pontos">Pontos Culturais</label><br>
                        <input type="radio" id="eventos" name="busca" value="eventos">
                        <label for="eventos">Eventos</label><br>
                        <input type="radio" id="comunidade" name="busca" value="comunidade">
                        <label for="comunidade">Comunidades</label><br>
                    </div>
                </form>
                </br></br>
                <img style="margin-top: -42px;" src="assets/slider.gif" class="slider" />
            </div>
        </div>
        <div id="sobre"></div>
    </div>
    </div>
    </br></br></br></br></br></br></br></br></br></br>
    <div class="block">
        <div class="container">
            <div class="row">
                <p>
                    </br>
                    </br>
                </p>
                <div class="col-md-6 align-self text-center order-md-1 order-2">
                    <img src="assets/SOBRE.svg" class="img-fluid" height="700" width="580" />
                </div>
                <div class="col-md-6 col-md-4  align-self-center order-md-2 order-1 mb-md-0 mb-4">
                    <h2 class="title">Saiba mais</h2>
                    <p class="mb-4">
                        Esse sistema permite que o usuário adicione e visualize pontos culturais, marque presença e crie eventos, além de ter a possibilidade de participar de comunidades com base nas suas preferências.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer id="contato">
        <p>
            </br>
            </br>
            </br>

        </p>
        <div class="container">
            <div class="email">
                <img src="assets/duvida.svg" />
                <h2 class="title text-center">Ficou com alguma dúvida?</h2>
                <h4 class="subtitle text-center mb-4">Entre em contato conosco.</h4>
                <div class="flex-md-grow-1 pr-md-3 pb-md-0 pb-3">
                    <a href="mailto:adm.ofc.arq@gmail.com" class="btn btn-light button mb-3 d-md-inline d-block w-100">Enviar dúvida</a>
                </div>
            </div>
            <div class=" py-4">
                <div class="row">
                    <div class="col-md-7 align-self-center text-md-left text-right">
                        <ul>
                            <li>
                                <a href="#"><img src="assets/icon-facebook.svg" /></a>
                            </li>
                            <li>
                                <a href="#"><img src="assets/icon-instagram.svg" /></a>
                            </li>
                            <li>
                                <a href="#"><img src="assets/icon_github.svg" /></a>
                            </li>
                            <li>
                                <a href="#"><img src="assets/icon-whatsapp.svg" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>

</html>