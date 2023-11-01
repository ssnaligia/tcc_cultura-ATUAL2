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
    <title>Filtro - Pontos Culturais</title>
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
            width: 80%;
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

        #resultados-filtro {
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

        p {
            margin-top: 0;
            margin-right: 177px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
<a class="legend2" href="todosPontos.php" style="position: absolute;">
        <span style="position: relative; z-index: 1; right: 685px; top: 10px;">
            <small style="font-size: 15px;">Voltar</small>
        </span>
        <i class="uil uil-arrow-left" style="font-size: 35px; right: 730px; position: relative; top: -15px; z-index: 2;"></i>
    </a>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $categoria = $_POST["categoria"];
        $filtro_categoria = !empty($categoria) ? " WHERE p.categoria = " . (int)$categoria : "";
        $sql = "SELECT p.id_ponto, p.nome_ponto, p.descricao, p.endereco, i.diretorio_imagem 
            FROM PontosCulturais p
            LEFT JOIN Imagens i ON p.id_ponto = i.id_ponto" . $filtro_categoria;
        $conexao = obterConexao();
        $resultado = $conexao->query($sql);
    ?>
        <div id="resultados-filtro" style="margin-left: 232px;">
        <?php
        if ($resultado->num_rows > 0) {
            while ($ponto = $resultado->fetch_assoc()) {
                $categoria = $_POST["categoria"];
                switch ($categoria) {
                    case 1:
                        $categoria = "Eventos no Geral";
                        break;
                    case 2:
                        $categoria = "Teatro";
                        break;
                    case 3:
                        $categoria = "Dança";
                        break;
                    case 4:
                        $categoria = "Literatura";
                        break;
                    case 5:
                        $categoria = "Música";
                        break;
                    case 6:
                        $categoria = "Política";
                        break;
                    case 7:
                        $categoria = "Esporte";
                        break;
                    case 8:
                        $categoria = "Manifestações Religiosas";
                        break;
                    case 9:
                        $categoria = "Entretenimento/Cinema";
                        break;
                    case 10:
                        $categoria = "Shows";
                        break;
                    case 11:
                        $categoria = "Debates";
                        break;
                }
                echo '<section class="box-container" style="">';
                echo '<div class="formEst2">';
                echo '<h3 style="color: #000; text-align: center;"></h3>';
                echo '<h3 class="title" style="color: #000;">' . $ponto['nome_ponto'] . '</h3>';
                echo '<h7 style="color: #000; text-transform: uppercase;">Categoria: ' . $categoria . '</h7>';
                echo '<a href="mostrarPontos.php?id_ponto=' . $ponto['id_ponto'] . '">Ver mais</a>';
                echo '</div>';
            }
        } else {
            echo '<p class="aviso">Nenhum ponto cultural encontrado para a categoria selecionada.</p>';
        }

        $conexao->close();
    }
        ?>
        </section>
        </div>