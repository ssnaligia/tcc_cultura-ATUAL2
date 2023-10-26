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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Avaliar Evento</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .botoes {
            display: flex;
            align-content: space-around;
            justify-content: space-evenly;
            flex-direction: row;
        }

        .aprov {
            font-size: 19px;
            border: none;
            border-radius: .1rem;
            background-color: #5d782e;
            letter-spacing: 1px;
            padding: 5px 25px;
            cursor: pointer;
            text-align: center;
            align-items: center;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
        }

        .apag {
            font-size: 19px;
            border: none;
            border-radius: .1rem;
            background-color: #ad1714;
            letter-spacing: 1px;
            padding: 5px 25px;
            cursor: pointer;
            text-align: center;
            align-items: center;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <section class="add-ponto">
        <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
        <p>
            <?php
            include("../../util/mensagens.php");
            include("../../util/tempoMsg.php");
            ?>
        </p>

        <?php
        $id_evento = $_GET['id_evento'];
        $sql = "SELECT * FROM Eventos WHERE id_evento = $id_evento";
        $conexao = obterConexao();
        $result = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_assoc($result);

        $id_ponto_referencial = $row['id_ponto'];

        $sqlPonto = "SELECT nome_ponto FROM PontosCulturais WHERE id_ponto = $id_ponto_referencial";
        $resultPonto = mysqli_query($conexao, $sqlPonto);
        $rowPonto = mysqli_fetch_assoc($resultPonto);
        $nome_ponto_referencial = $rowPonto['nome_ponto'];

        $categoria = $row['categoria'];

        $sqlCategoria = "SELECT nome_categoria FROM Categoria WHERE id_categoria = $categoria";
        $resultCategoria = mysqli_query($conexao, $sqlCategoria);
        $rowCategoria = mysqli_fetch_assoc($resultCategoria);
        $nome_categoria = $rowCategoria['nome_categoria'];

        $data_evento_formatada = date('d/m/Y', strtotime($row['data_evento']));
        ?>
        <div class="container-form2">
            <form class="form2" action="funcaoEvento.php" method="post">
                <h3 class="title" style="color: #000;">APROVAR EVENTO</h3>
                <div class="inputform2">
                    <input type="text" placeholder="Nome" name="nome_evento" id="id_evento" value="<?php echo $row['nome_evento']; ?>" readonly required>
                </div>
                <div class="inputform2" style="margin-top: 0.5rem;">
                    <input type="text" placeholder="Ponto Referencial" name="nome_ponto" id="id_ponto" value="<?php echo $nome_ponto_referencial; ?>" readonly required>
                </div>
                <div class="inputform2">
                    <input type="text" id="id_data" placeholder="Data" name="data_evento" readonly value="<?php echo $data_evento_formatada; ?>">
                </div>
                <div class="inputform2">
                    <input type="text" id="id_horario" placeholder="Horário" name="horario_evento" readonly value="<?php echo date('H:i', strtotime($row['horario'])); ?>">
                </div>
                <div class="inputform2">
                    <input type="text" id="id_categoria" placeholder="Categoria" name="categoria" readonly value="<?php echo $nome_categoria; ?>">
                </div>
                <div class="inputform2">
                    <input type="text" id="id_descricao" placeholder="Descrição" name="descricao" readonly value="<?php echo $row['descricao_evento']; ?>">
                </div>
                <p>
                    </br>
                    </br>
                </p>
                <input type="hidden" name="id_evento" value="<?php echo $id_evento; ?>">
                <div class="botoes">
                    <button type="submit" class="aprov" name="aprov">Aprovar</button></a>
                    <button type="submit" class="apag" name="apag">Apagar</button></a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>