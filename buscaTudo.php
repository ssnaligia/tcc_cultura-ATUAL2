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

        .formEst {
            background-color: #d3beaf;
            padding: 2rem;
            width: 26rem;
            border-radius: 4px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            display: flex;
            flex-direction: column;
        }

        .formEst .title::before {
            content: "";
            position: absolute;
            margin-left: 0px;
            margin-top: 30px;
            height: 3px;
            width: 30px;
            background-color: #915c37;
            border-radius: 25px;
        }

        .formEst a {
            color: #915c37;
            text-decoration: none;
            cursor: pointer;
        }

        .formEst a:hover {
            color: #957660;
            text-decoration: underline;
        }
    </style>
</head>

<body>
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

            if ($resultado->num_rows > 0) {
                while ($linha = $resultado->fetch_assoc()) {
                    echo '<div class="formEst">';
                    echo '<h3 style="color: #000; text-align: center;"></h3>';
                    echo '<h3 class="title" style="color: #000;">' . $linha['nome_ponto'] . '</h3>';
                    echo '<a href="mostrarPontos.php?id_ponto=' . $linha['id_ponto'] . '">Ver mais</a>';
                    echo '</div>';
                }
            } else {
                echo 'Nenhum resultado encontrado para a palavra-chave: ' . $palavraChave;
            }
        } elseif ($opcaoBusca === 'eventos') {
            $sql = "SELECT * FROM Eventos WHERE nome_evento LIKE '%$palavraChave%'";
        } elseif ($opcaoBusca === 'comunidade') {
            $sql = "SELECT * FROM Comunidade WHERE nome_comunidade LIKE '%$palavraChave%'";
        } else {
            echo 'Nenhum resultado encontrado para a palavra-chave: ' . $palavraChave;
        }
    }
    ?>
</body>

</html>
S