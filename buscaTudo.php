<?php
    require("sistema_bd.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Busca - Pontos Culturais</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .formEst2 {
            background-color: #d3beaf;
            padding: 2rem;
            width: 60%;
            border-radius: 4px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            display: flex;
            flex-direction: column;
        }

        .formEst2 .title::before {
            content: "";
            position: absolute;
            margin-left: 0px;
            margin-top: 30px;
            height: 3px;
            width: 30px;
            background-color: #915c37;
            border-radius: 25px;
        }

        .formEst2 a {
            color: #915c37;
            text-decoration: none;
            cursor: pointer;
        }

        .formEst2 a:hover {
            color: #957660;
            text-decoration: underline;
        }

        #resultados-pesquisa{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            width: 100vw;
        }

        .formEst2 .title::before {
            content: "";
            position: absolute;
            margin-left: 0px;
            margin-top: 35px;
            height: 3px;
            width: 30px;
            background-color: #915c37;
            border-radius: 25px;
        }
    </style>
</head>

<body>
<a class="legend2" href="index.php" style="position: absolute;">
        <span style="position: relative; z-index: 1; right: 1085px; top: -20px;">
            <small style="font-size: 15px;">Voltar</small>
        </span>
        <i class="uil uil-arrow-left" style="font-size: 35px; right: 1130px; position: relative; top: -35px; z-index: 2;"></i>
    </a>
    <?php
    if (isset($_SESSION['logado'])) {
        $email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
        $email = $_SESSION['usuario_logado'];
        buscarNomeUser($email);
    }

    $previousPage = $_SERVER['HTTP_REFERER'];

    if (isset($_GET['id_ponto'])) {
        $id_ponto = (int)$_GET['id_ponto'];
        $_SESSION["id_ponto"] = $id_ponto;

        $conexao = obterConexao();
        $sql = "SELECT * FROM PontosCulturais WHERE id_ponto = $id_ponto";
        $result = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            header("Location: pagina_de_erro.php");
            exit;
        }
    }

    $conexao = obterConexao();

    if (isset($_GET['palavraChave']) && isset($_GET['busca'])) {
        $palavraChave = $_GET['palavraChave'];
        $opcaoBusca = $_GET['busca'];

        $sql = ""; // Inicialize a consulta SQL

        if ($opcaoBusca === 'pontos') {
            $sql = "SELECT * FROM PontosCulturais WHERE nome_ponto LIKE '%$palavraChave%'";

            $resultado = $conexao->query($sql);
        ?>
        <div id="resultados-pesquisa">
        <?php
            if ($resultado->num_rows > 0) {
                while ($linha = $resultado->fetch_assoc()) {
                    echo '<section class="box-container">';
                    echo '<div class="formEst2">';
                    echo '<h3 style="color: #000; text-align: center;"></h3>';
                    echo '<h3 class="title" style="color: #000;">' . $linha['nome_ponto'] . '</h3>';
                    echo '<a href="mostrarPontos.php?id_ponto=' . $linha['id_ponto'] . '">Ver mais</a>';
                    echo '</div>';
                }
            } else {
                echo 'Nenhum resultado encontrado para a palavra-chave: ' . $palavraChave;
            }
        } elseif ($opcaoBusca === 'eventos') {
            $sql = "SELECT * FROM Eventos WHERE nome_evento LIKE '%$palavraChave%' ORDER BY data_evento";

            $resultado = $conexao->query($sql);
        ?>
        <div id="resultados-pesquisa">
            <?php
            
            if ($resultado->num_rows > 0) {
                while ($linha = $resultado->fetch_assoc()) {
                $data_evento_formatada = date('d/m/Y', strtotime($linha['data_evento']));
                echo '<div class="formEst2" style="width: 30%!important;">';
                echo '<div class="box" style="margin-top: 13px; width: 382px !important;">';
                echo '<div class="content">';
                echo '<div class="icons">';
                echo '<h3>' . $linha['nome_evento'] . '</h3>';
                echo '</div>';
                echo '<p><i class="uil uil-calendar-alt"></i> ' . $data_evento_formatada . '</p>';
                echo '</div>'; 
                echo '</div>'; 
                echo '</div>';
            } 
        } else {
                echo 'Nenhum resultado encontrado para a palavra-chave: ' . $palavraChave;
        }
     } elseif ($opcaoBusca === 'comunidade') {
            $sql = "SELECT * FROM Comunidade WHERE nome_comunidade LIKE '%$palavraChave%'";

            $resultado = $conexao->query($sql);
            ?>
            <div id="resultados-pesquisa">
                <?php
                
                if ($resultado->num_rows > 0) {
                    while ($linha = $resultado->fetch_assoc()) {
                        echo '<div class="formEst2" style="width: 30%!important;">';
                        echo '<div class="col-md-6">';
                        echo '<div class="h-100 p-5 text-bg rounded-3 comunidade" style="background: #d3beaf; border-radius: 5px;">';
                        echo '<div class="col-md-2">';
                        echo '<img src="assets/comunidade.png" width="80px" height="80px">';
                        echo '</div>';
                        echo '<h2 class="title" style="font-weight: 700;">' . $linha['nome_comunidade'] . '</h2>';
                        echo '<h7>Descrição:  ' . $linha['descricao_comunidade'] . '</h7>';
                        echo '<br><br>';
                        echo '</div>'; 
                        echo '</div>'; 
                        echo '</div>';
                    }   
        } else {
            echo 'Nenhum resultado encontrado para a palavra-chave: ' . $palavraChave;
        }}
    }
    ?>
        </div>
    </div>
</body>

</html>