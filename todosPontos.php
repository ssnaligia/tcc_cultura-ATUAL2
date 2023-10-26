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
            height: 100vh;
        }

        .formEst {
            background-color: #d3beaf;
            padding: 2rem;
            height: 450px;
            width: 26rem;
            border-radius: 4px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            margin-top: -50px;
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
        }

        .col-md-4 {
            max-width: 100%;
        }
    </style>
</head>

<body>
    <a class="legend2" href="<?php echo $previousPage; ?>" style="position: absolute;">
        <span style="position: relative; z-index: 1; right: 620px; top: 50px;">
            <small style="font-size: 15px;">Voltar</small>
        </span>
        <i class="uil uil-arrow-left" style="font-size: 35px; position: relative; top: -15px; z-index: 2; right: 665px; top: 30px;"></i>
    </a>
    <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>

    <div class="areaTdsPontos" id="areaTdsPontos">
        <h3 style="color: #000; text-align: center; z-index: 1;">TODOS OS PONTOS</h3>

        <?php
        $sql = "SELECT * FROM PontosCulturais WHERE aprovado = 1";
        $conexao = obterConexao();
        $result = mysqli_query($conexao, $sql);

        // Verifique se há resultados
        if (mysqli_num_rows($result) == 0) {
            echo "<p style='text-align: center;'>Nenhum ponto cultural encontrado.</p>";
        } else {
            echo "<p><br></p>";

            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col-md-4 formEst">
                <h3 class="title" style="color: #000;"><?php echo $row['nome_ponto']; ?></h3>
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
        }
        ?>
    </div>
</body>

</html>