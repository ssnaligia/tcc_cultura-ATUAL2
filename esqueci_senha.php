<?php
require("sistema_bd.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <a class="legend2" href="login.php"><small style="font-size: 15px; position: absolute; right: 645px; top: 30px;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 650px; top: 0px;"></i></a>
</header>

<body class="body-cadastro">
    <div class="container-cadastro">
        <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
        <p>
            <?php
            include("util/mensagens.php");
            include("util/tempoMsg.php");
            ?>
        </p>
        <div class="forms">
            <div class="form-cadastro">
                <p><span class="title">Recuperação de senha</span></p>
                <form action="recuperacaoSenha.php" method="post" id="form">
                    <div class="input-field">
                        <input type="email" placeholder="Email" class="form-control" id="id_email" name="email" required>
                        <i class="uil uil-envelope icon"></i>
                        <small>Usuário já cadastrado!</small>
                    </div>
                    <div class="text-center text-danger pt-3" id="id_msg"></div>
                    <div class="input-field button-cadastro">
                        <a href="#" onclick="document.getElementById('form').submit();"><input type="submit" value="Recuperar" style="margin-top: -8%;" id="btn_rec"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/validate.js"></script>
    <script src="js/scriptCadastro.js"></script>
</body>

</html>