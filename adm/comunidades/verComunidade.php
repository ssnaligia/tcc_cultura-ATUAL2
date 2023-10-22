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
    <title>Avaliar Comunidade</title>
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

        <div class="container-form2">
            <?php
            $id_comunidade = $_GET['id_comunidade'];
            $sql = "SELECT * FROM Comunidade WHERE id_comunidade = $id_comunidade";
            $conexao = obterConexao();
            $result = mysqli_query($conexao, $sql);
            $row = mysqli_fetch_assoc($result);
            ?>
            <form class="form2" action="funcaoComunidade.php" method="post">
                <h3 class="title" style="color: #000;">APROVAR COMUNIDADE</h3>
                <div class="inputform2">
                    <input type="text" placeholder="Nome" name="nome_comunidade" id="id_comunidade" value="<?php echo $row['nome_comunidade']; ?>" readonly required>
                </div>
                <div class="inputform2" style="margin-top: 0.5rem;">
                    <input type="text" placeholder="Idade Mínima" name="idade" id="id_idade" value="<?php echo $row['idade_minima']; ?>" readonly required>
                </div>
                <div class="inputform2">
                    <textarea placeholder="Descrição" rows="5" cols="25" style="width: 100%; border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #d3beaf; border-top: 2px solid
                                transparent; padding: 0.5rem;" maxlength="" name="descricao" id="id_descricao" readonly required><?php echo $row['descricao_comunidade']; ?></textarea>
                </div>
                <p>
                    </br>
                    </br>
                </p>
                <input type="hidden" name="id_comunidade" value="<?php echo $id_comunidade; ?>">
                <div class="botoes">
                    <button type="submit" class="aprov" name="aprov">Aprovar</button></a>
                    <button type="submit" class="apag" name="apag">Apagar</button></a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>