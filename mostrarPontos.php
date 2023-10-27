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
        }

        .statusT {
            color: #000;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            align-content: space-around;
        }

        .statusS {
            color: #a58c7a;
            font-weight: bold;
            text-transform: uppercase;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-content: stretch;
            justify-content: space-evenly;
        }

        .seta {
            color: #915c37;
            position: relative;
            margin-top: 60px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-BJeoPeE2fBQZVZveqD8m9/xm0JTkZa5wjrPkCue5o/s=" crossorigin="anonymous"></script>

    <?php
    if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest") {
        require("sistema_bd.php");

        $conexao = obterConexao();

        if (isset($_POST["categoria"])) {
            $categoria = $_POST["categoria"];

            $sql = "SELECT p.id_ponto, p.nome_ponto, p.descricao, p.endereco, i.diretorio_imagem 
            FROM PontosCulturais p
            LEFT JOIN Imagens i ON p.id_ponto = i.id_ponto";

            if (!empty($categoria)) {
                $sql .= " WHERE p.categoria = " . (int)$categoria;
            }

            $resultado = mysqli_query($conexao, $sql);

            $pontosCulturais = array();

            if (mysqli_num_rows($resultado) > 0) {
                while ($ponto = mysqli_fetch_assoc($resultado)) {
                    $pontosCulturais[] = array(
                        'id_ponto' => $ponto['id_ponto'],
                        'nome_ponto' => $ponto['nome_ponto'],
                        'endereco' => $ponto['endereco'],
                        'descricao' => $ponto['descricao'],
                        'diretorio_imagem' => $ponto['diretorio_imagem'],
                    );
                }
            }

            mysqli_close($conexao);

            echo json_encode($pontosCulturais);
            exit;
        }
    }
    ?>

    <section class="add-ponto">
        <a href="<?php echo $previousPage; ?>"><i class="uil uil-arrow-left seta" style="font-size: 35px;"></i></a>
        <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>

        <p>
            <?php
            include("util/mensagens.php");
            include("util/tempoMsg.php");
            ?>
        </p>

        <div class="container-form2">
            <?php
            if (isset($_SESSION["id_ponto"])) {
                $id_ponto = $_SESSION["id_ponto"];
            } else {
                echo "A variável de sessão 'id_ponto' não está definida.";
            }
            $sql = "SELECT * FROM PontosCulturais WHERE id_ponto = $id_ponto";
            $conexao = obterConexao();
            $result = mysqli_query($conexao, $sql);
            $row = mysqli_fetch_assoc($result);
            ?>
            <form class="form2" action="funcaoPonto.php" method="post">
                <h6 class="subtitle statusT">STATUS:</h6>
                <h6 class="statusS"><?php echo $aprovado = ($row['aprovado'] == 0) ? 'Pendente à Avaliação' : 'Aprovado'; ?></h6>
                </br>
                <h3 class="title" style="color: #000;"><?php echo $row['nome_ponto']; ?></h3>


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
                    $id_ponto = $_SESSION["id_ponto"];
                    function obterImagensPorIdPonto($id_ponto)
                    {
                        $conexao = obterConexao();

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
                    $imagens = obterImagensPorIdPonto($id_ponto);

                    foreach ($imagens as $imagem) {
                        echo '<img src="' . $imagem . '" alt="Imagem" width=150px height=150px style="object-fit: cover; margin-left: 10px;"><br>';
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
            </form>
        </div>
    </section>
</body>

</html>