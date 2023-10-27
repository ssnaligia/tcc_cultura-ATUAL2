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
    $preferencias = obterPreferenciasUsuario($email);
}
function obterPreferenciasUsuario($email)
{
    $preferencias = array();
    $sql = "SELECT categoria FROM Preferencias WHERE email = ?";
    $conexao = obterConexao();
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultado)) {
        $preferencias[] = $row['categoria'];
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);

    return $preferencias;
}
function logado()
{
    $_SESSION["msg"] = "Faça o login para realizar essa funcionalidade!";
    $_SESSION["tipo_msg"] = "alert-danger";
    session_destroy();
}

if (isset($_GET['executar_funcao'])) {
    logado();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos - ARQ Cultura</title>
    <style>
        .ativado {
            color: #915c37 !important;
            font-weight: bolder !important;
            border-bottom: solid 4px var(--primary) !important;
        }
    </style>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</header>
<div id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <img src="assets/logo.svg" class="navbar-brand img-fluid" height="200" width="200" />
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pontosCulturais.php">Pontos Culturais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ativado" href="eventos.php">Eventos</a>
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

        <body>
            <section class="evento">
                <h2 class="header title"><span style="position: absolute; margin-top: 20px; font-size: 25px; font-weight: 700;">RECOMENDAÇÕES DE EVENTOS</span></h2>
                <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) { ?>
                    <a class="legend3" href="cadastroEvento.php"><small style="font-size: 15px; position: absolute; right: 115px; top: 162px; color: #915c37">Adicionar</small>
                        <img src="assets/addEvento.svg" style="position: absolute; right: 130px; top: 125px;" width="38px" height="38px"></img>
                    </a>
                    <a class="legend3" href=""><small style="font-size: 15px; position: absolute; right: 215px; top: 145px; color: #915c37">
                            <div hidden>
                                <label for="categorias">
                                    <h7 style="text-transform: uppercase;">preferencias</h6>
                                        <select name="categorias[]" id="categorias" multiple required>
                                            <option value="2" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(2, $preferencias)) ? 'selected' : ''; ?>>Teatro</option>
                                            <option value="3" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(3, $preferencias)) ? 'selected' : ''; ?>>Dança</option>
                                            <option value="4" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(4, $preferencias)) ? 'selected' : ''; ?>>Literatura</option>
                                            <option value="5" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(5, $preferencias)) ? 'selected' : ''; ?>>Música</option>
                                            <option value="6" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(6, $preferencias)) ? 'selected' : ''; ?>>Política</option>
                                            <option value="7" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(7, $preferencias)) ? 'selected' : ''; ?>>Esporte</option>
                                            <option value="8" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(8, $preferencias)) ? 'selected' : ''; ?>>Manifestações Religiosas</option>
                                            <option value="9" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(9, $preferencias)) ? 'selected' : ''; ?>>Entretenimento/ Cinema</option>
                                            <option value="10" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(10, $preferencias)) ? 'selected' : ''; ?>>Shows</option>
                                            <option value="11" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(11, $preferencias)) ? 'selected' : ''; ?>>Debates</option>
                                        </select>
                                </label>
                            </div>
                    </a>
                    </small>
                    <img src="assets/addEvento.svg" style="position: absolute; right: 130px; top: 125px;" width="38px" height="38px"></img>
                    </a>
                <?php } else {
                } ?>

                </br></br></br>
                <section class="box-container">
                    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
                        $eventos = obterEventos();

                        if (is_array($eventos) && count($eventos) > 0) {
                            foreach ($eventos as $evento) {
                                $data_evento_formatada = date('d/m/Y', strtotime($evento['data_evento']));
                                $conexao = obterConexao();
                                $sql = "SELECT escolha FROM EscolhasUsuario WHERE email = '$email' AND id_evento = {$evento['id_evento']}";
                                $result = mysqli_query($conexao, $sql);
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $escolha = $row['escolha'];
                                    } else {
                                        $escolha = null;
                                    }
                                } else {
                                }
                                $_SESSION['id_evento'] = $evento['id_evento'];
                                // Defina o tamanho mínimo para o nome do evento
                                $tamanhoMinimoNome = 17; // Defina o tamanho mínimo desejado

                                // Verifique o tamanho do nome do evento
                                $nomeEvento = $evento['nome_evento'];
                                $marginTop = (strlen($nomeEvento) < $tamanhoMinimoNome) ? 'margin-top: 57px;' : 'margin-top: 13px;';
                                echo '<div class="box" style="margin-top: 13px; width: 382px !important;">';
                                echo '<div class="content">';
                                echo '<div class="icons">';
                                echo '<h3>' . $evento['nome_evento'] . '</h3>';
                                echo '</div>';
                                echo '<p style="' .$marginTop. '"><i class="uil uil-calendar-alt"></i> ' . $data_evento_formatada . '</p>';
                                echo '<h5>Local:</h5>';
                                echo '<p>' . $evento['nome_ponto'] . '</p>';
                                echo '<h5>Descrição:</h5>';
                                echo '<p>' . $evento['descricao_evento'] . '</p>';
                                echo '<h5>Categoria:</h5> ';
                                echo '<p>' . $evento['categoria'] . '</p>';
                                echo '<form class="form" action="salvarEscolha.php" method="post">';
                                echo '<div class="inputform2">';
                                echo '<label for="eventoSelect" style="color: #814a23;">Selecione:</label>';
                                echo '<select name="eventoSelect[' . $evento['id_evento'] . ']" style="border: none; outline: none; align-items: center; margin-left: 95px; background-color: #d3beaf; color: #814a23;" class="escolhaSelect" required>';
                                echo '<option value="" selected></option>';
                                echo '<option value="vou" ' . ($escolha == 'vou' ? 'selected' : '') . '>Vou</option>';
                                echo '<option value="interesse" ' . ($escolha == 'interesse' ? 'selected' : '') . '>Tenho interesse</option>';
                                echo '</select>';
                                echo '</div>';
                                echo '<button type="submit" style="margin-top: 15px; width: 350px;" class="btn button-secondary btn-secondary button d-md-inline-block d-block salvar-escolha">Salvar</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p style="margin-top: 150px;" class="aviso">Nenhum evento encontrado.</p>';
                        }
                    } else {
                        $eventos = obterEventos();

                        if (is_array($eventos) && count($eventos) > 0) {
                            foreach ($eventos as $evento) {
                                $_SESSION['id_evento'] = $evento['id_evento'];
                                $data_evento_formatada = date('d/m/Y', strtotime($evento['data_evento']));

                                // Defina o tamanho mínimo para o nome do evento
                                $tamanhoMinimoNome = 17; // Defina o tamanho mínimo desejado

                                // Verifique o tamanho do nome do evento
                                $nomeEvento = $evento['nome_evento'];
                                $marginTop = (strlen($nomeEvento) < $tamanhoMinimoNome) ? 'margin-top: 57px;' : 'margin-top: 13px;';
                                echo '<div class="box" style="margin-top: 13px; width: 325px !important;">';
                                echo '<div class="content">';
                                echo '<div class="icons">';
                                echo '<h3>' . $nomeEvento . '</h3>';
                                echo '</div>';
                                echo '<p style="' .$marginTop. '"><i class="uil uil-calendar-alt"></i> ' . $data_evento_formatada . '</p>';
                                echo '<h5 style="margin-top: 10px;">Local:</h5>';
                                echo '<p>' . $evento['nome_ponto'] . '</p>';
                                echo '<h5>Descrição:</h5>';
                                echo '<p>' . $evento['descricao_evento'] . '</p>';
                                echo '<h5>Categoria:</h5> ';
                                echo '<p>' . $evento['categoria'] . '</p>';
                                echo '<a href="?executar_funcao=1">';
                                echo '</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "<p style='text-align: center;'>Nenhum evento encontrado.</p>";
                        }
                    }
                    ?>

                    <script>
                        <?php if (isset($_SESSION["msg"]) && !empty($_SESSION["msg"])) { ?>
                            var mensagemDiv = document.getElementById("mensagem");
                            mensagemDiv.innerHTML = "<?php echo $_SESSION["msg"]; ?>";
                            mensagemDiv.className = "alert <?php echo $_SESSION["tipo_msg"]; ?>";

                            mensagemDiv.style.display = "block";

                            setTimeout(function() {
                                mensagemDiv.style.display = "none";
                            }, 3000);
                        <?php } ?>
                    </script>
                </section>
                <footer id="contato">
                    <p>
                        </br>
                    </p>
                    <div class="py-4" style="margin-top: 400px;">
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
                    new MultiSelectTag('categorias')
                </script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        </body>

</html>