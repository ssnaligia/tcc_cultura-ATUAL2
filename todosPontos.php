<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
    $email = $_SESSION['usuario_logado'];
    buscarNomeUser($email);
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

        .col-md-4 {
            margin-right: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <a href="<?php echo $previousPage; ?>"><i class="uil uil-arrow-left seta" style="font-size: 35px;"></i></a>
        <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>

       
        <div class="areaTdsPontos" id="areaTdsPontos">
                <h3 style="color: #000; text-align: center;">TODOS OS PONTOS</h3>
                <p><br></p>
             
                <?php
                $sql = "SELECT * FROM PontosCulturais WHERE aprovado = 1";
                $conexao = obterConexao();
                $result = mysqli_query($conexao, $sql);

                $count = 0; // Contador para controlar o número de pontos culturais por linha
                ?>

                <div class="row"> <!-- Inicia uma nova linha -->
                <p>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                    </p>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-md-4 formEst"> <!-- Cada ponto cultural em uma coluna de 4 partes da largura -->
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
                                <textarea placeholder="Descrição" rows="5" cols="25" style="background-color: #d3beaf; width: 100%; border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #d3beaf; border-top: 2px solid
                                    transparent; padding: 0.5rem;" maxlength="" name="descricao" id="id_descricao" readonly required><?php echo $row['descricao']; ?></textarea>
                            </div>
                            <p>
                                </br>
                                </br>
                            </p>
                        </div>

                        <?php
                        $count++;
                        if ($count % 3 == 0) { // Fecha a linha após três pontos culturais
                            echo '</div>'; // Fecha a linha
                            echo '<div class="row">'; // Inicia uma nova linha
                        }
                        ?>
                    <?php } ?>
                </div> <!-- Fecha a última linha -->