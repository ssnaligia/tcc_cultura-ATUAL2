<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="styesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<div id="header">
    <div class="container">
        <img src="assets/logo.svg" class="navbar-brand img-fluid" height="200" width="200" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="pontosCulturais.php">Pontos Culturais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="eventos.php">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comunidade.php">Comunidade</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
                            $nome_usuario = $_SESSION['nome_user'];
                            echo '<a class="legend" href="perfil2.php"><h1 class="legend" style="font-size: 16px; position: absolute; right: -76px; top: 2px; font-weight: normal;">' . $nome_usuario . '</h1><i class="perfil" style="position: absolute; right: -50px; top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></i></a>';
                        } else {
                            echo '<a class="legend" href="login.php"><p class="legend" style="font-size: 16px; position: absolute; right: -76px; top: 2px;">Entrar</p><i class="perfil" style="position: absolute; right: -65px; top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></i></a>';
                        } ?>
                    </li>
                    <li class="nav-item">
                        <a class="legend" href="duvidas.php">
                            <small style="font-size: 15.4px; position: absolute; right: -130px; top: 3px;">Ajuda</small>
                            <i class="bi bi-question-circle" style="position: absolute; right: -125px; top: -46.5px; font-size: 39px;">
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
            <section class="add-ponto">
                </head>

                <body>
                    <h1>Avalie esse ponto:</h1>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form class="form" enctype="multipart/form-data" action="processa.php" method="post">
                        <div class="rating">
                            <input type="radio" name="rating" id="star5" value="5"><label for="star5"></label>
                            <input type="radio" name="rating" id="star4" value="4"><label for="star4"></label>
                            <input type="radio" name="rating" id="star3" value="3"><label for="star3"></label>
                            <input type="radio" name="rating" id="star2" value="2"><label for="star2"></label>
                            <input type="radio" name="rating" id="star1" value="1"><label for="star1"></label>
                        </div>
                        <button type="submit" class="button2">Enviar Avaliação</button>
                        <script src="script_star.js"></script>
                    </form>
            </section>
            <footer id="contato">
                <p>
                    </br>
                    </br>
                </p>
                <div class="py-4">
                    <div class="row">
                        <div class="col-md-7 align-self-center text-md-left text-right">
                        <p style="width: 308px; margin-left: 550px;">©Todos os direitos reservados.</p>
                        <ul>
                            <li style="color: #bda18e; font-size: 15px; text-align: center; margin-top: -12px;">
                            Equipe ARQ Cultura
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <script>
                let subMenu = document.getElementById("subMenu");

                function toggleMenu() {
                    subMenu.classList.toggle("open-menu");
                }
            </script>
        </body>

</html>