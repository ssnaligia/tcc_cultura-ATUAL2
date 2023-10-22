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
    <title>Avaliar Ponto</title>
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
            $id_ponto = $_GET['id_ponto'];
            $sql = "SELECT * FROM PontosCulturais WHERE id_ponto = $id_ponto";
            $conexao = obterConexao();
            $result = mysqli_query($conexao, $sql);
            $row = mysqli_fetch_assoc($result);
            ?>
            <form class="form2" action="funcaoPonto.php" method="post">
                <h3 class="title" style="color: #000;">APROVAR PONTO</h3>
                <div class="inputform2">
                    <input type="text" placeholder="Nome" name="nome_ponto" id="id_ponto" value="<?php echo $row['nome_ponto']; ?>" readonly required>
                </div>
                <div class="inputform2" style="margin-top: 0.5rem;">
                    <input type="text" placeholder="Endereço" name="endereco" id="id_endereco" value="<?php echo $row['endereco']; ?>" readonly required>
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
                    <input type="text" id="categoria" placeholder="Categoria" name="categoria" readonly value="<?php echo $categoria; ?>">
                </div>
                <div class="inputform2" style='margin: 20px; display: flex; /* overflow: scroll; */ justify-content: space-around; flex-direction: row; background: #a58c7a; padding: 10px; border-radius: 3px; overflow-x: scroll;'>
                    <?php
                    $id_ponto = $_GET['id_ponto'];
                    function obterImagensPorIdPonto($id_ponto)
                    {
                        $conexao = obterConexao();

                        // Consulta SQL para obter todas as imagens com o mesmo id_ponto
                        $sql = "SELECT diretorio_imagem FROM Imagens WHERE id_ponto = $id_ponto";
                        $result = mysqli_query($conexao, $sql);

                        $imagens = array();

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $imagens[] = $row['diretorio_imagem'];
                            }
                        }

                        return $imagens;
                    }
                    // Exemplo de uso da função:
                    $imagens = obterImagensPorIdPonto($id_ponto);

                    // Loop para exibir as imagens
                    foreach ($imagens as $imagem) {
                        echo '<img src="../../' . $imagem . '" alt="Imagem" width=150px height=150px style="object-fit: cover; margin-left: 10px;"><br>';
                    }
                    ?>

                </div>
                <div class="inputform2">
                    <textarea placeholder="Descrição" rows="5" cols="25" style="width: 100%; border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #d3beaf; border-top: 2px solid
                                transparent; padding: 0.5rem;" maxlength="" name="descricao" id="id_descricao" readonly required><?php echo $row['descricao']; ?></textarea>
                </div>
                <p>
                    </br>
                    </br>
                </p>
                <input type="hidden" name="id_ponto" value="<?php echo $id_ponto; ?>">
                <div class="botoes">
                    <button type="submit" class="aprov" name="aprov">Aprovar</button></a>
                    <button type="submit" class="apag" name="apag">Apagar</button></a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>