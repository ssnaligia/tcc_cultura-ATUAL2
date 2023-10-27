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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pontos Culturais - ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe64Z2dRsH8QPQe2iPnUNS-hEl7q0JLs8&libraries=places&callback=initMap2" async defer></script>
    <script>
        var searchInput = 'id_endereco';

        function initMap2() {
            var autocomplete;
            autocomplete = new google.maps.places.Autocomplete(document.getElementById(searchInput), {
                types: ['geocode'],
                componentRestrictions: {
                    country: "BR", // Código do país (no formato ISO 3166-1 alfa-2)
                }
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var near_place = autocomplete.getPlace();
            });
        }
    </script>


    <style>
        .ativado {
            color: #915c37 !important;
            font-weight: bolder !important;
            border-bottom: solid 4px var(--primary) !important;
        }

        .title-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
        }

        .title {
            color: #000;
            margin-bottom: 1rem;
        }

        .button2 {
            width: 380px !important;
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
                </ul>
            </div>
        </nav>

        <body>
            <section class="add-ponto">
                <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
                <p>
            <?php
            include("util/mensagens.php");
            include("util/tempoMsg.php");
            ?>
        </p>
                </br>
                <div class="container-form2">
                    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) { ?>
                        <iframe class="mapa" src="mapaApi.php" allowfullscreen=" " loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <?php } else { ?>
                        <iframe class="mapa2" src="mapaApi.php" allowfullscreen=" " loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <?php } ?>
                    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) { ?>
                        <a class="legend3" href="todosPontos.php"><small style="font-size: 15px; position: absolute; right: 265px; top: 162px; color: #915c37">Ver Pontos</small>
                            <img src="assets/pontosTodos.png" style="color: #915C37; position: absolute; right: 290px; top: 135px; font-size: 25px;" width="28px" height="28px" alt="map-marker" />
                        </a>
                        <form class="form2" enctype="multipart/form-data" action="salvarPonto.php" method="post">
                                <h3 class="title" style="color: #000;">Adicione um ponto</h3>
                            <div class="inputform2">
                                <input type="text" placeholder="Nome" name="nome_ponto" id="id_ponto" required>
                            </div>
                            <div class="inputform2" style="margin-top: 0.5rem;">
                                <input type="text" placeholder="Endereço" name="endereco" id="id_endereco" required>
                            </div>
                            <div class="inputform2" style="border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #915c37; border-top: 2px solid transparent; padding: 0.5rem; ">
                                <label for="categoria" style="color: #814a23;">Categoria</label>
                                <select id="categoria" name="categoria" style="border: none; outline: none; align-items: center; margin-left: 55px; background-color: #d3beaf;" required>
                                    <option value="" selected>Selecione</option>
                                    <option value="1">Eventos no Geral</option>
                                    <option value="2">Teatro</option>
                                    <option value="3">Dança</option>
                                    <option value="4">Literatura</option>
                                    <option value="5">Música</option>
                                    <option value="6">Política</option>
                                    <option value="7">Esporte</option>
                                    <option value="8">Manifestações Religiosas</option>
                                    <option value="9">Entretenimento/Cinema</option>
                                    <option value="10">Shows</option>
                                    <option value="11">Debates</option>
                                </select>
                            </div>
                            <div class="inputform2">
                                <input name="imagens" type="file" multiple />
                            </div>
                            <div class="inputform2">
                                <textarea placeholder="Descrição" rows="5" cols="25" style="width: 100%; border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #d3beaf; border-top: 2px solid
                                transparent; padding: 0.5rem;" maxlength="" name="descricao" id="id_descricao" required></textarea>
                            </div>
                            <p>
                                </br>
                                </br>
                            </p>
                            <button type="submit" class="button2" style="align-itens: center; width: 160px;">Adicionar</button>
                        </form>
                        <?php } else { ?><?php } ?>
                </div>
            </section>
            <div class="areaComentarios" id="areaComentarios">
                <p>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                </p>

                <h3 style="color: #000; text-align: center;">COMENTÁRIOS</h3>
                <p>
                    </br>
                </p>
                <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) { ?>
                    <div id="comentario" class="inputform2" style="text-align: center; position: relative;">
                        <form id="formComentario" action="addComentario.php" method="post">
                            <textarea rows="3" name="comentario" id="id_comentario" placeholder="Digite seu comentário..." style="background-color: #e6d3c5; width: 600px; display: inline-block; border-radius: 2px; border: none; outline: none; margin: 0 auto; margin-top: 0; padding: 0.5rem 2rem 0.5rem 0.5rem;" required></textarea>
                            <a href="" style="text-decoration: none; color: #915c37; position: absolute; top: 10px; right: 300px;">
                                <button class="btn-reset" type="submit" style="border: none; outline: none; background-color: transparent;"><i class="uil uil-message" style="font-size: 26px; color: #814a23;"></i></button>
                            </a>
                        </form>
                    </div>
                    <?php } else { ?><?php } ?>
                    <p>
                        </br>
                    </p>

                    <?php
                    require_once("database/conecta_bd.php");

                    $sql = "SELECT c.*, cad.nome FROM Comentarios c
                                JOIN Cadastro cad ON c.email = cad.email
                                ORDER BY c.data_publicacao DESC";
                    $conexao = obterConexao();
                    $resultado = mysqli_query($conexao, $sql);

                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            $nomeUsuario = $row['nome']; // ou qualquer outra coluna que contenha o nome da pessoa
                            $dataPublicacao = date('d/m/Y - H:i', strtotime($row['data_publicacao']));
                            $comentario = $row['comentario'];
                    ?>
                            <div class="comentario" style="width: 600px; margin: 0 auto; margin-bottom: 15px;">
                                <div class="info">
                                    <h5><?php echo $nomeUsuario; ?></h5>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <h6 style="color: #ba9880; margin-right: 10px;"><?php echo $dataPublicacao; ?></h6>
                                        <a href="excluirComentario.php?id=<?php echo $row['id_comentario']; ?>" alt="Excluir"><i class="uil uil-trash-alt" style="font-size: 23px; color: #814a23;"></i></a>
                                    </div>
                                </div>
                                <p><?php echo $comentario; ?></p>
                            </div>

                    <?php
                        }
                    } else {
                        echo "<p style='text-align: center;'>Nenhum comentário encontrado.</p>";
                    }
                    mysqli_close($conexao);
                    ?>

            </div>
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
            <script>
                let subMenu = document.getElementById("subMenu");

                function toggleMenu() {
                    subMenu.classList.toggle("open-menu");
                }
            </script>

        </body>

</html>