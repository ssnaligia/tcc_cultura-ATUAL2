<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
    sleep(4);
    unset($_SESSION['msg']);
    unset($_SESSION['tipo_msg']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body class="body-cadastro">
    <a class="legend2" href="login.php"><small style="font-size: 15px; position: absolute; right: 645px; top: 30px;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 650px; top: 0px;"></i></a>

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
                <p><span class="title">Cadastro</span></p>
                <form action="verificacaoEmail.php" method="post" id="form-login">
                    <div class="input-field">
                        <input type="text" placeholder="Nome" class="form-control" id="id_nome" name="nome" required>
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="input-field valida">
                        <input type="email" placeholder="Email" class="form-control" id="id_email" name="email" onblur="validarEmail()" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>

                    <script>
                        function validarEmail() {
                            var emailInput = document.getElementById('id_email');
                            var email = emailInput.value;

                            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                            if (!regex.test(email)) {
                                var errorMsg = 'O e-mail inserido não é válido. Verifique novamente.';
                                window.location.href = 'erro.php?msg=' + encodeURIComponent(errorMsg);
                            }
                        }
                    </script>
                    <div class="input-field">
                        <input type="tel" id="id_telefone" name="telefone" placeholder="Telefone" maxlength="16" oninput="formatarTelefone(this)" required>
                        <script>
                            function formatarTelefone(input) {
                                var telefone = input.value.replace(/\D/g, '');

                                if (telefone.length === 11) {
                                    telefone = '(' + telefone.substr(0, 2) + ') ' + telefone.substr(2, 5) + '-' + telefone.substr(7, 4);
                                }

                                input.value = telefone;
                            }
                        </script>
                        <i class="uil uil-phone"></i>
                    </div>
                    <div class="input-field data">
                        <input type="text" placeholder="Data de Nascimento" id="id_data" name="data_nasc" style="color:#6c757d;" required>
                        <i class="uil uil-calendar-alt"></i>
                    </div>

                    <script>
                        var dataInput = document.getElementById('id_data');

                        dataInput.addEventListener('input', function() {
                            var inputValue = this.value;
                            var formattedDate = formatarData(inputValue);

                            this.value = formattedDate;
                        });

                        function formatarData(data) {
                            var dataLimpa = data.replace(/\D/g, '');

                            if (dataLimpa.length === 8) {
                                var dia = dataLimpa.substr(0, 2);
                                var mes = dataLimpa.substr(2, 2);
                                var ano = dataLimpa.substr(4, 4);
                                var dataFormatada = dia + '/' + mes + '/' + ano;

                                return dataFormatada;
                            } else if (dataLimpa.length > 8) {
                                var dia = dataLimpa.substr(0, 2);
                                var mes = dataLimpa.substr(2, 2);
                                var ano = dataLimpa.substr(4, 4);
                                var dataFormatada = dia + '/' + mes + '/' + ano;

                                return dataFormatada;
                            } else {
                                return data;
                            }
                        }
                    </script>

                    <div class="input-field">
                        <input type="password" class="password" placeholder="Crie sua senha" minlength="8" maxlength="12" id="id_senha" name="senha" required onkeyup="validarSenha()">
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Confirme sua senha" minlength="8" maxlength="12" id="id_confirmar" name="confirmar" required onkeyup="senhasIguais()">
                        <i class="uil uil-lock icon"></i>
                    </div>
                    <div hidden>
                        <p>Tipo de Perfil:</p>
                        <input type="radio" id="id_tipo" name="id_tipo" value="2" checked required>
                        <label for="id_tipo">Usuário</label><br>
                    </div>
                    <div style="margin-top: 5px; text-align: text-center">
                    </div>
                    <p id="mensagem"></p>
                    <div class="input-field button-cadastro">
                        <input type="submit" style="margin-top: -3%; text-align: center; background-color: #915c37; border: none; color: #fff; font-size: 17px; font-weight: 500; letter-spacing: 1px; border-radius: 6px; padding: .5rem 8.5rem;" id="btn_cadastro" disabled>Cadastrar</input>
                    </div>
                </form>
                <div class="cadastro-signup">
                    <span class="text">Já tem uma conta?
                        <a href="login.php" class="text signup-link">Entre!</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="js/validate.js"></script>
    <script src="js/scriptCadastro.js"></script>
</body>

</html>