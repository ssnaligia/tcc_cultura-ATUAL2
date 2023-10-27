<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $redirecionarUsuario = 0;
} else {
    $redirecionarUsuario = 1;
}
$email = $_SESSION["usuario_logado"];
?>
<!DOCTYPE>
<html lang="pt-br">
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</header>
<a class="legend2" href="<?php echo (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) ? 'perfil2.php' : 'login.php'; ?>"><small style="font-size: 15px; position: absolute; right: 645px; top: 30px;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 650px; top: 0px;"></i></a>

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
                <p><span class="title">Alterar senha</span></p>
                <small>A senha precisa ter pelo menos oito caracteres e incluir uma combinação de números, pelo menos uma letra maiúscula e uma minúscula e um caracter especial (@$!%*?&_).</small>
                <form action="verificacaoSenha.php" method="post" id="form">
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Crie sua senha" minlength="8" maxlength="12" id="id_senha" name="senha" required onkeyup="validarSenha()">
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Confirme sua senha" minlength="8" maxlength="12" id="id_confirmar" name="confirmar" required onkeyup="senhasIguais()">
                        <i class="uil uil-lock icon"></i>
                    </div>
                    <p id="mensagem"></p>
                    <div class="input-field button-cadastro">
                        <input type="submit" value="Confirmar" style="margin-top: -8%;" id="btn_cadastro" disabled></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/validate.js"></script>
    <script src="js/scriptCadastro.js"></script>
</body>

</html>