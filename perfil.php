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

<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/select.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://icons8.com/icon/98955/selecionado">
    <title>Perfil</title>
</header>

<div id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="<?php echo (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) ? 'public/indexUsuario.php' : 'index.php'; ?>"><img src="assets/logo.svg" class="navbar-brand img-fluid" height="200" width="200" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="pontosCulturais.php">Pontos Culturais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="eventos.php">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comunidade.php">Comunidade</a>
                    </li>
                </ul>
            </div>
        </nav>
        <a class="legend" href="logout.php"><small style="font-size: 15.4px; position: absolute; left: -35px; top: 5px; text-decoration: none; color: #915c37;">Sair</small>
            <i class="uil uil-signout" style="position: absolute; right: 5px; top: -40px; color: #814a23; font-size: 36px;"></i>
        </a>
        <a class="legend" href="duvidas.php"><small style="font-size: 15.4px; position: absolute; right: -52px; top: 5px;">Ajuda</small>
            <i class="bi bi-question-circle" style="position: absolute; right: -46px; top: -46.8px; font-size: 39px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                </svg>
            </i>
        </a>
    </div>
</div>

<body style="overflow-x: hidden;">
    <section class="section-perfil">
        </br>
        <div class="perfil-header" style="margin-left: 1%;">
            <div class="perfil-port">
                <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
                <p>
                    <?php
                    include("util/mensagens.php");
                    include("util/tempoMsg.php");
                    ?>
                </p>
                <div class="perfil-avatar" style="margin-left: 106px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="170" height="170" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="perfil-body">
            <div class="perfil-bio">
                <h3 style="margin-left: 124px;" class="title"><?php echo $nome; ?></h3>
            </div>
        </div>
        <div class="perfil-footer">
            <div class="lista-dados" style="margin-left: 260px;">
                <h4 class="title">Dados<a href="formAlterarPerfil.php" style="text-decoration: none; color: #814a23;"><i class="uil uil-edit"></i></a></h4>
                <li><i class="email"></i>Email: <?php echo $perfil[0]['email']; ?></li>
                <li><i class="fone"></i>Fone: <?php echo $perfil[0]['telefone']; ?></li>
                <li><i class="nascimento"></i>Data de nascimento: <?php echo date('d/m/Y', strtotime($perfil[0]['data_nasc'])); ?></li>

                <p></br></p>
                <a href="trocarSenha.php" style="text-decoration: none; position: absolute; top: 660px;"><button type="submit" class="button-login input-field" style="text-align: center; background-color: #915c37; border: none; color: #fff; font-size: 17px; font-weight: 500; letter-spacing: 1px; border-radius: 6px; padding: .5rem 9.5rem;" id="btn_login">Trocar Senha</button></a>

                <div class="lista-dados" style="position: absolute; right: -200px; top: 500px;">
                    <h4 class="title">Criações</h4>
                    <li><i class="pontos"></i></li>
                    <li><i class="eventos"></i></li>
                </div>
                <div class="lista-atividades" style="position: absolute; right: 340px; top: 800px;">
                    <h4 class="title">Atividades</h4>
                    <li><i class="atividades-user"></i></li>
                    <li><i class="atividades-user"></i></li>
                </div>
                <p></br></br></p>
            </div>
    </section>
    <footer id="contato" style="margin-top: 200px;">
        <p></br></br></p>
        <div class="py-4" style="margin-left: -50px">
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
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('categorias') // id
    </script>
</body>

</html>