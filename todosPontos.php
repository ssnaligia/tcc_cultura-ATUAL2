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

// Defina o número de pontos culturais por página e a página atual
$pontosPorPagina = 3;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Certifique-se de que $paginaAtual seja um número inteiro válido

if ($paginaAtual <= 0) {
    $paginaAtual = 1;
}

// Calcule o deslocamento para a consulta SQL
$offset = ($paginaAtual - 1) * $pontosPorPagina;

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Ponto Cultural</title>
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
            height: 450px;
            width: 26rem;
            border-radius: 4px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
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

        .areaTdsPontos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 25px;
            /* Ajuste a margem superior conforme necessário */
        }

        .col-md-4 {
            max-width: 100%;
            margin-bottom: 20px;
            /* Espaço entre as linhas */
        }

        a {
            color: #915c37;
            text-decoration: none;
            cursor: pointer;
        }

        a:hover {
            color: #957660;
            text-decoration: underline;
        }

        .pagination {
            position: relative;
            margin-left: -1490px;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #915c37;
            background-color: #bda18e;
            border-color: #915c37;
        }

        .page-link {
            position: relative;
            display: block;
            color: #915c37;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .page-link:hover {
            position: relative;
            display: block;
            color: #bda18e;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .filtro {
            position: fixed;
            right: 37px;
            top: 85px;
        }

        .botaoFiltro {
            margin-top: 6px;
            margin-left: 323px;
            background-color: #915C37;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 5px 10px;
            font-size: 13px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="filtro">
        <form id="filtroForm" action="filtroPontos.php" method="post">
            <div class="inputform2" style="border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #915c37; border-top: 2px solid transparent; padding: 0.5rem; ">
                <label for="categoria" style="color: #814a23;">Categoria</label>
                <select id="categoria" name="categoria" style="border: none; outline: none; align-items: center; margin-left: 55px; background-color: #d3beaf;" required>
                    <option value="" selected>Todas</option>
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
            <input class="botaoFiltro" type="submit" value="Filtrar">
        </form>
    </div>

    <a class="legend2" href="pontosCulturais.php" style="position: absolute;">
        <span style="position: relative; z-index: 1; right: 940px; top: 50px;">
            <small style="font-size: 15px;">Voltar</small>
        </span>
        <i class="uil uil-arrow-left" style="font-size: 35px; position: relative; top: -15px; z-index: 2; right: 985px; top: 30px;"></i>
    </a>
    <h3 style="color: #000; text-align: center; position: absolute; margin-left: 30px; margin-top: -620px;">TODOS OS PONTOS</h3>
    <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>


    <div class="areaTdsPontos" id="areaTdsPontos">
        <h3 style="color: #000; text-align: center; z-index: 1;"></h3>

        <?php
        $conexao = obterConexao();
        $totalPontosSql = "SELECT COUNT(*) AS total FROM PontosCulturais WHERE aprovado = 1";
        $totalPontosResult = mysqli_query($conexao, $totalPontosSql);
        $totalPontos = mysqli_fetch_assoc($totalPontosResult)['total'];

        // Calcula o número total de páginas
        $totalPaginas = ceil($totalPontos / $pontosPorPagina);

        $sql = "SELECT * FROM PontosCulturais WHERE aprovado = 1 LIMIT $pontosPorPagina OFFSET $offset";
        $result = mysqli_query($conexao, $sql);

        // Verifique se há resultados
        if (mysqli_num_rows($result) == 0) {
            echo "<p style='text-align: center;'>Nenhum ponto cultural encontrado.</p>";
        } else {
            echo "<div class='areaTdsPontos'>";

            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="col-md-4 formEst">
                    <h3 class="title" style="color: #000;"><?php echo $row['nome_ponto']; ?></h3><a href="mostrarPontos.php?id_ponto=<?php echo $row['id_ponto']; ?>">Ver mais</a>
                    <div class="inputform2" style="margin-top: 0.5rem;">
                        <label for="id_endereco" style="font-weight: bold; color: #915c37; margin-top: 10px;">Endereço:</label>
                        <input type="text" placeholder="Endereço" style="background-color: #d3beaf; margin-top: 0px;" name="endereco" id="id_endereco" value="<?php echo $row['endereco']; ?>" readonly required>
                    </div>
                    <?php
                    $categoria = $row['categoria'];
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
                    ?>
                    <div class="inputform2">
                        <label for="id_endereco" style="font-weight: bold; color: #915c37; margin-top: 20px;">Categoria:</label>
                        <input type="text" id="categoria" placeholder="Categoria" name="categoria" style="background-color: #d3beaf; margin-top: 0px;" readonly value="<?php echo $categoria; ?>">
                    </div>
                    <div class="inputform2">
                        <label for="id_endereco" style="font-weight: bold; color: #915c37; margin-top: 25px;">Descrição:</label>
                        <div style="max-height: 150px; overflow-y: auto;">
                            <p><?php echo $row['descricao']; ?></p>
                        </div>
                    </div>
                    <p>
                        <br>
                        <br>
                    </p>
                </div>

        <?php
            }
            echo "</div>";
            echo "<nav aria-label='Navegação de página exemplo' style='margin-top: 550px;'>";
            echo "<ul class='pagination justify-content-center'>";

            // Página Anterior
            if ($paginaAtual > 1) {
                $paginaAnterior = $paginaAtual - 1;
                echo "<li class='page-item'><a class='page-link' href='todosPontos.php?pagina=$paginaAnterior' aria-label='Anterior'><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Anterior</span></a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link' aria-hidden='true'>&laquo;</span></li>";
            }

            // Páginas numeradas
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<li class='page-item " . ($paginaAtual == $i ? 'active' : '') . "'><a class='page-link' href='todosPontos.php?pagina=$i'>$i</a></li>";
            }

            // Próxima Página
            if (mysqli_num_rows($result) == $pontosPorPagina) {
                $proximaPagina = $paginaAtual + 1;
                echo "<li class='page-item'><a class='page-link' href='todosPontos.php?pagina=$proximaPagina' aria-label='Próximo'><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Próximo</span></a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link' aria-hidden='true'>&raquo;</span></li>";
            }

            echo "</ul>";
            echo "</nav>";
        }
        ?>
</body>

</html>