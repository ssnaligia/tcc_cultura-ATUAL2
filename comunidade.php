<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
    $email = $_SESSION['usuario_logado'];
    buscarNomeUser($email);
    $perfil = perfilUsuario($email);
}

function logado() {
    $_SESSION["msg"] = "Faça o login para realizar essa funcionalidade!";
    $_SESSION["tipo_msg"] = "alert-danger";
}

// Verifique se o link foi clicado
if (isset($_GET['executar_funcao'])) {
    logado();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidades - ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        .ativado {
            color: #915c37 !important;
            font-weight: bolder !important;
            border-bottom: solid 3px var(--primary) !important;
        }
    </style>
</head>
<div id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <img src="assets/logo.svg" class="navbar-brand img-fluid" height="200" width="200" />
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                        <a class="nav-link" href="pontosCulturais.php">Pontos Culturais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="eventos.php">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ativado" href="comunidade.php">Comunidades</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
                            $nome_usuario = $_SESSION['nome_user'];
                            echo '<a class="legend" href="perfil.php"><h1 class="legend" style="font-size: 16px; position: absolute; right: -76px; top: 2px; font-weight: normal;">' . $nome_usuario . '</h1><i class="perfil" style="position: absolute; right: -50px; top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></i></a>';
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
                </ul>
            </div>
        </nav>
        <body style="background-color: #ede1d8">
            <h2 class="header title"><span style="position: absolute; margin-top: 20px; font-size: 25px; font-weight: 700;">Sugestões de Comunidade</span></h2>

            </br>
            <?php
            if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
                $comunidades = obterComunidades();

                if (is_array($comunidades) && count($comunidades) > 0) {
                    echo '</br></br>';
                    foreach ($comunidades as $comunidade) {
                        echo '<div class="row align-items-md-stretch">';
                        echo '<div class="col-md-6">';
                        echo '<div class="h-100 p-5 text-bg rounded-3" style="background: #d3beaf;">';
                        echo '<div class="col-md-2">';
                        echo '<img src="assets/comunidade.png" width="80px" height="80px">';
                        echo '</div>';
                        echo '<h2 class="title" style="font-weight: 700;">' . $comunidade['nome_comunidade'] . '</h2>';
                        echo '<h6>Qntd de Membros: 07 usuários</h6>';
                        echo '<h7>Idade Mínima: ' . $comunidade['idade_minima'] . '</h7>';
                        echo '</br></br>';
                        echo '<h7>Descricão:  ' . $comunidade['descricao_comunidade'] . '</h7>';
                        echo '</br></br>';
                        echo '<a href="modeloChat.php">';
                        echo '<button class="btn" type="button" style="color: #ffff; background-color: #915c37;"> <img src="assets/porta.png" height="30px" width="30px"> Entrar</button>';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="margin-top: 150px;" class="aviso">Nenhuma comunidade encontrada.</p>';
                }
            } else {
                echo '</br></br>';
                echo '<div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>';
                include("util/mensagens.php");
                include("util/tempoMsg.php");
                $comunidades = obterComunidades();

                if (is_array($comunidades) && count($comunidades) > 0) {
                    echo '</br></br>';
                    foreach ($comunidades as $comunidade) {
                        echo '<div class="row align-items-md-stretch" style="margin-top: -20px;">';
                        echo '<div class="col-md-6">';
                        echo '<div class="h-100 p-5 text-bg rounded-3" style="background: #d3beaf;">';
                        echo '<div class="col-md-2">';
                        echo '<img src="assets/comunidade.png" width="80px" height="80px">';
                        echo '</div>';
                        echo '<h2 class="title" style="font-weight: 700;">' . $comunidade['nome_comunidade'] . '</h2>';
                        echo '<h6>Qntd de Membros: 07 usuários</h6>';
                        echo '<h7>Idade Mínima: ' . $comunidade['idade_minima'] . '</h7>';
                        echo '</br></br>';
                        echo '<h7>Descricão:  ' . $comunidade['descricao_comunidade'] . '</h7>';
                        echo '</br></br>';
                        echo '<a href="?executar_funcao=1">';
                        echo '<button class="btn" type="button" style="color: #ffff; background-color: #915c37;"> <img src="assets/porta.png" height="30px" width="30px"> Entrar</button>';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="margin-top: 150px;" class="aviso">Nenhuma comunidade encontrada.</p>';
                }
            }

            ?>
            <p>
                </br>
                </br>
            </p>
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) { ?>
            <a class="legend3" href="addComunidade.php"><small style="font-size: 15px; position: absolute; right: 105px; top: 162px; color: #915c37">Adicionar</small>
                <i class="uil uil-comment-alt-plus" style="color: #915C37; position: absolute; right: 130px; top: 135px; font-size: 25px;" width="38px" height="38px"></i>
            </a>
            <?php } else {} ?>
            <footer id="contato">
                <p>
                    </br>
                    </br>
                </p>
                <div class="py-4">
                    <div class="row">
                        <div class="col-md-7 align-self-center text-md-left text-right">
                            <ul>
                                <li>
                                    <a href="# "><img src="assets/icon-facebook.svg" /></a>
                                </li>
                                <li>
                                    <a href="# "><img src="assets/icon-instagram.svg" /></a>
                                </li>
                                <li>
                                    <a href="# "><img src="assets/icon_github.svg" /></a>
                                </li>
                                <li>
                                    <a href="# "><img src="assets/icon-whatsapp.svg" /></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </body>

</html>