<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
    $email = $_SESSION['usuario_logado'];
    $nome = buscarNomeUser($email);
}

$perfil = perfilUsuario($email);

$preferencias = obterPreferenciasUsuario($email);

function obterPreferenciasUsuario($email)
{
    $preferencias = array();
    $sql = "SELECT categoria FROM Preferencias WHERE email = ?";
    $conexao = obterConexao();
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultado)) {
        $preferencias[] = $row['categoria'];
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);

    return $preferencias;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARQ Cultura</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/select.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        #id_data::placeholder {
            color: #212529;
        }
    </style>
</header>
<script>
    function formatar(mascara, documento) {
        var i = documento.value.length;
        var saida = mascara.substring(0, 1);
        var texto = mascara.substring(i)
        if (texto.substring(0, 1) != saida) {
            documento.value += texto.substring(0, 1);
        }
    }
</script>
</header>
<a class="legend2" href="perfil.php"><small style="font-size: 15px; position: absolute; right: 645px; top: 30px;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 650px; top: -9px;"></i></a>

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
                <p><span class="title">Alterar Perfil</span></p>
                <form action="alterarPerfil.php" method="post" id="form-login">
                    <input type="hidden" name="email" value="<?= $perfil[0]["email"] ?>">
                    <div class="input-field">
                        <input type="text" placeholder="Nome" class="form-control" id="id_nome" style="color: #00000;" name="nome" value="<?= $perfil[0]["nome"] ?>" required>
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="input-field">
                        <input type="tel" id="id_telefone" name="telefone" placeholder="Telefone" value="<?= $perfil[0]["telefone"] ?>" maxlength="16" oninput="formatarTelefone(this)" required>
                        <script>
                            function formatarTelefone(input) {
                                // Remove todos os caracteres que não são dígitos
                                var telefone = input.value.replace(/\D/g, '');

                                // Verifica se o número de telefone tem 11 dígitos (incluindo o DDD)
                                if (telefone.length === 11) {
                                    // Formata o número de telefone no formato (DD) XXXXX-XXXX
                                    telefone = '(' + telefone.substr(0, 2) + ') ' + telefone.substr(2, 5) + '-' + telefone.substr(7, 4);
                                }

                                // Atualiza o valor do campo de entrada com o número de telefone formatado
                                input.value = telefone;
                            }
                        </script>
                        <i class="uil uil-phone"></i>
                    </div>
                    <div class="input-field data">
                        <input type="text" placeholder="Data de Nascimento" style="color: #00000;" id="id_data" name="data_nasc" value="<?= date('d/m/Y', strtotime($perfil[0]["data_nasc"])) ?>" style="color:#6c757d;" minlength="10" maxlength="10" required>
                        <i class="uil uil-calendar-alt"></i>
                    </div>
                    <script>
                        var dataInput = document.getElementById('id_data');

                        dataInput.addEventListener('blur', function() {
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
                            } else if (dataLimpa.length === 10) {
                                var dia = dataLimpa.substr(0, 2);
                                var mes = dataLimpa.substr(3, 2);
                                var ano = dataLimpa.substr(6, 4);
                                var dataFormatada = dia + '/' + mes + '/' + ano;

                                return dataFormatada;
                            } else {
                                return data;
                            }
                        }
                    </script>
                    <p></br></p>
                    <div>
                        <label for="categorias">
                            <h6 style="text-transform: uppercase;">Preferências</h6>
                            <select name="categorias[]" id="categorias" multiple required>
                                <option value="2" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(2, $preferencias)) ? 'selected' : ''; ?>>Teatro</option>
                                <option value="3" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(3, $preferencias)) ? 'selected' : ''; ?>>Dança</option>
                                <option value="4" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(4, $preferencias)) ? 'selected' : ''; ?>>Literatura</option>
                                <option value="5" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(5, $preferencias)) ? 'selected' : ''; ?>>Música</option>
                                <option value="6" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(6, $preferencias)) ? 'selected' : ''; ?>>Política</option>
                                <option value="7" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(7, $preferencias)) ? 'selected' : ''; ?>>Esporte</option>
                                <option value="8" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(8, $preferencias)) ? 'selected' : ''; ?>>Manifestações Religiosas</option>
                                <option value="9" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(9, $preferencias)) ? 'selected' : ''; ?>>Entretenimento/ Cinema</option>
                                <option value="10" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(10, $preferencias)) ? 'selected' : ''; ?>>Shows</option>
                                <option value="11" <?php echo (isset($preferencias) && is_array($preferencias) && in_array(11, $preferencias)) ? 'selected' : ''; ?>>Debates</option>
                            </select>
                        </label>
                    </div>
                    <div hidden>
                        <p>Tipo de Perfil:</p>
                        <input type="radio" id="id_tipo" name="id_tipo" value="2" checked required>
                        <label for="id_tipo">Usuário</label><br>
                    </div>
                    <div style="margin-top: 5px; text-align: text-center">
                    </div>
                    <p id="mensagem"></p>
                    <div class="input-field">
                        <input type="submit" value="Salvar" style="margin-top: -3%; text-align: center; background-color: #915c37; border: none; color: #fff; font-size: 17px; font-weight: 500; letter-spacing: 1px; border-radius: 6px; padding: .5rem 8.5rem;"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/validate.js"></script>
    <script src="js/scriptCadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('categorias') // id
    </script>
</body>

</html>