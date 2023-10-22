<?php
require("sistema_bd.php");
$_SESSION["usuario_logado"];
?>

<!DOCTYPE html>
<html lang="pt-br">

<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css" />
    <title>ARQ Cultura</title>
</header>

<body class="body-login">
    <div class="container-login editSelect">
        <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
        <p>
            <?php
            include("util/mensagens.php");
            include("util/tempoMsg.php");
            ?>
        </p>
        <div class="forms">
            <div class="form-login">
                <form action="codeSelect.php" method="POST">
                    <div hidden>
                        <p>Email:</p>
                        <input type="email" placeholder="Email" class="form-control" id="id_email" name="email" value="<?php if (isset($_SESSION['usuario_logado']) == true) {
                                                                                                                            echo $_SESSION['usuario_logado'];
                                                                                                                        } ?>" required>
                    </div>
                    <p><span class="title">Selecione</span></p>
                    <p><span class="subtitle">Escolha ao menos uma opção de sua preferência.</span></p>
                    <select name="categorias[]" class="custom-select" multiple required>
                        <option value="2">Teatro</option>
                        <option value="3">Dança</option>
                        <option value="4">Literatura</option>
                        <option value="5">Música</option>
                        <option value="6">Política</option>
                        <option value="7">Esporte</option>
                        <option value="8">Manifestações Religiosas</option>
                        <option value="9">Entretenimento/ Cinema</option>
                        <option value="10">Shows</option>
                        <option value="11">Debates</option>
                    </select>
                    <div class="container-select">
                        <button type="submit" class="button-login input-field" style="text-align: center; background-color: #915c37; border: none; color: #fff; font-size: 17px; font-weight: 500; letter-spacing: 1px; border-radius: 6px; padding: .5rem 5.5rem;" name="btn_select">Selecionar</button>
                    </div>
            </div>
        </div>
    </div>

    <script src="js/scriptSelect.js"></script>
</body>

</html>