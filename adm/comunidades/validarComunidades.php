<?php
require("../../sistema_bd.php");
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
    <title>ARQ Cultura - ADM</title>
    <link rel="stylesheet" href="../../css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: "Roboto", sans-serif !important;
        }

        .navCor {
            background-color: #ede1d8 !important;
        }

        .buttonVer {
            background-color: #ede1d8;
        }

        .card {
            background-color: #ede1d8 !important
        }

        .ativado {
            color: #915c37 !important;
            font-weight: bold;
            font-style: italic;
        }

        .naoAtivado {
            color: #915c37 !important;
        }

        tr {
            color: #7a614d;
            background-color: #bda18e;
        }

        .qntd {
            display: flex !important;
            flex-direction: row;
            align-content: flex-end;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .msgQntd {
            text-transform: uppercase;
            font-size: 18px;
            font-weight: 600;
            color: #6b4812;
        }
    </style>
</head>

<body>
    <div class="aaa" style="height: 100%;/* flex: auto; */display: flex; flex-direction: row;">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light navCor" style="width: 280px; height: 100vh;" id="sidebar-admin">
                <img src="../../assets/logo.svg" alt="logo" class="img-fluid" width="200px" height="200px">
s            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="../pontos/validarPontos.php" class="nav-link naoAtivado" aria-current="page">
                        Pontos Culturais
                    </a>
                </li>
                <li>
                    <a href="../eventos/validarEventos.php" class="nav-link naoAtivado">
                        Eventos
                    </a>
                </li>
                <li>
                    <a href="validarComunidades.php" class="nav-link ativado">
                        Comunidades
                    </a>
                </li>
            </ul>
            <hr>
            <a href="../../logout.php" style="color: #814a23; font-weight: bold; text-decoration: none;">Sair</a></li>
        </div>
        <div class="card" style="width: 170vh;">
            <p>
                </br>
            </p>
            <div class="qntd">
                <?php
                $sqlCount = "SELECT COUNT(*) AS qntdNaoAprov FROM Comunidade WHERE aprovado = 0";
                $conexao = obterConexao();
                $resultadoCount = mysqli_query($conexao, $sqlCount);
                $qntdNaoAprov = mysqli_fetch_assoc($resultadoCount); ?>
                <h5 class="msgQntd">Qntd de Comunidades pendentes de avaliação = <?php echo $qntdNaoAprov['qntdNaoAprov']; ?></h5>
            </div>
            <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
            <p>
                <?php
                include("../../util/mensagens.php");
                include("../../util/tempoMsg.php");
                ?>
            </p>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Idade Mínima</th>
                        <th scope="col">Aprovado</th>
                        <th scope="col">Ver mais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM Comunidade";
                    $conexao = obterConexao();
                    $result = mysqli_query($conexao, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $aprovado = ($row['aprovado'] == 0) ? 'Não' : 'Sim';
                        $classe_css = ($row['aprovado'] == 0) ? 'linhaAmarela' : 'linhaVerde';
                        echo "<tr style='color: " . ($classe_css == 'linhaAmarela' ? '#ede1d8' : '#915c37') . "; background-color: " . ($classe_css == 'linhaAmarela' ? '#7a614d' : '#d3beaf') . ";'>";
                        echo "<td name='id'>" . $row['id_comunidade'] . "</td>";
                        echo "<td>" . $row['nome_comunidade'] . "</td>";
                        echo "<td>" . $row['idade_minima'] . "</td>";
                        echo "<td>" . $aprovado . "</td>";
                        echo "<td><a class='btn btn-sm buttonVer' href='verComunidade.php?id_comunidade=" . $row["id_comunidade"] . "&nome=" . $row['nome_comunidade'] . "'>Ver mais</a> </td>
            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script>

        </script>
</body>

</html>