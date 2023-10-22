<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
    $email = $_SESSION['usuario_logado'];
    $nome = buscarNomeUser($email);
    $perfil = perfilUsuario($email);
}
if (isset($_SESSION['logado'])) {
    $redirecionarUsuario = 0;
} else {
    $redirecionarUsuario = 1;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <style>
        .quadrado {
            background-color: #915C37;
            border-radius: 20px;
            color: white;
            display: flex;
            height: 35vh;
            align-items: center;
            padding: 70px;
            padding-top: 90px;
            margin-top: 20px;
            justify-content: space-between;
            align-content: center;
            flex-direction: row;
            width: 70.5vw;
        }

        .nome {
            font-size: 84px !important;
            text-transform: uppercase;
            font-weight: 600 !important;
            margin-top: 30px;
        }

        h3 {
            margin-top: 30px !important;
            font-weight: 400 !important;
        }

        .botoes-acao {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-acao {
            background-color: white;
            padding: 10px;
            margin: 5px;
            border-radius: 4px;
            font-weight: 500 !important;
            color: #915c37;
            text-decoration: none;
        }

        .btn-acao:hover {
            text-decoration: none;
            color: #915C37;
        }

        .innerdados {
            display: flex;
            flex-direction: row;
        }

        .leftdados {
            display: flex;
            flex-direction: column;
            color: #915C37;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }

        .rightdados {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            color: #000;
            text-align: right;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }

        .info {
            height: 40vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 62vw;
        }

        h2.titleInfo.header.title::before {
            content: "";
            position: absolute;
            margin-left: 0px;
            margin-top: 385px;
            height: 4px;
            width: 30px;
            background-color: #915C37;
            border-radius: 25px;
        }

        .linha-vertical {
            border-color: #915C37 !important;
            height: 200px;
            /*Altura da linha*/
            border-left: 3px solid;
            /* Adiciona borda esquerda na div como ser fosse uma linha.*/
        }

        .criacoes,
        .dados {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 17vh;
        }

        .pai {
            display: flex;
            flex-direction: column;
            align-content: center;
            align-items: center;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pontos Culturais - ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
                        <a class="nav-link ativado" href="pontosCulturais.php">Pontos Culturais</a>
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

<body>
    <div class="pai">
        <div class="quadrado">
            <div class="bem-vindo">
                <h3>Bem-vindo(a)</h3>
                <h1 class='nome'><?php echo ($nome); ?></h1>
            </div>
            <div class="botoes-acao">
                <a href="formAlterarPerfil.php" class='btn-acao' style="width: 127px; text-align: center;">
                    Alterar Perfil
                </a>
                <a href="trocarSenha.php" class='btn-acao'>Trocar Senha</a>
            </div>
        </div>

        <div class="info">
            <div class="dados">
                <h2 class="titleInfo header title">DADOS</h2>
                <div class="innerdados">
                    <div class="leftdados">
                        <span>Email:</span>
                        <span>Telefone:</span>
                        <span>Data de Nascimento:</span>
                    </div>
                    <div class="rightdados">
                        <span><?php echo $perfil[0]['email']; ?></span>
                        <span><?php echo $perfil[0]['telefone']; ?></span>
                        <span><?php echo date('d/m/Y', strtotime($perfil[0]['data_nasc'])); ?></span>
                    </div>
                </div>
            </div>
            <div class="linha-vertical"></div>
            <div class="criacoes">
                <h2 class="titleInfo header title">CRIAÇÕES</h2>
                <div class="cu"></div>
                <div class="innerdados">
                    <div class="leftdados">
                        <span>Email:</span>
                        <span>Telefone:</span>
                        <span>Data de Nascimento:</span>
                    </div>
                    <div class="rightdados">
                        <span><?php echo $perfil[0]['email']; ?></span>
                        <span><?php echo $perfil[0]['telefone']; ?></span>
                        <span><?php echo date('d/m/Y', strtotime($perfil[0]['data_nasc'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>