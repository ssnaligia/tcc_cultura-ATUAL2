<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $email = $_SESSION['usuario_logado'];
    buscarNomeUser($email);
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
    <style>
        .ativado {
            color: #915c37 !important;
            font-weight: bolder !important;
            border-bottom: solid 4px var(--primary) !important;
        }

        .inputform2 input {
            width: 355px;
            margin-left: 10px;
            color: #000;
            padding: 0.5rem;
        }

        .textarea {
            width: 330px;
            border-radius: 2px;
            border: none;
            outline: none;
            margin-top: 0.5rem;
            align-items: center;
            display: flex;
            border-bottom: 2px solid #d3beaf;
            border-top: 2px solid transparent;
            padding: 0.5rem;
            margin-left: 3px;
        }

        .categoria {
            width: 355px;
            margin-left: 9px;
            border-radius: 2px;
            border: none;
            outline: none;
            margin-top: 0.5rem;
            align-items: center;
            display: flex;
            border-bottom: 2px solid #915c37;
            border-top: 2px solid transparent;
            padding: 0.5rem;
        }

        .container-form {
            margin-left: 255px;
            display: flex !important;
            align-items: center;
            display: flex;
            padding: 40px;
            justify-content: center;
            max-width: 450px;
            width: 408px;
            background-color: #d3beaf;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgb(0 0 0 / 10%);
        }

        .inputEv {
            width: 355px;
            margin-left: 11px;
            border-radius: 2px;
            border: none;
            outline: none;
            margin-top: 0.5rem;
            align-items: center;
            display: flex;
            border-bottom: 2px solid #915c37;
            border-top: 2px solid transparent;
            padding: 0.5rem;
        }

        .selectEv {
            border: none;
            width: 183px;
            margin-left: 40px;
            outline: none;
            align-items: center;
            background-color: #d3beaf;
        }
    </style>
</head>
<body>
    <div id="header">
        <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <img src="assets/logo.svg" class="navbar-brand img-fluid" height="200" width="200" />
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pontosCulturais.php">Pontos Culturais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ativado" href="eventos.php">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comunidade.php">Comunidades</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
                            $nome_usuario = $_SESSION['nome_user'];
                            echo '<a class="legend" href="perfil2.php"><h1 class="legend" style="font-size: 16px; position: absolute; right: -76px; top: 2px; font-weight: normal;">' . $nome_usuario . '</h1><i class="perfil" style="position: absolute; right: -50px; top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></i></a>';
                        } else {
                            echo '<a class="legend" href="login.php"><p class="legend" style="font-size: 16px; position: absolute; right: -76px; top: 2px;">Entrar</p><i class="perfil" style="position: absolute; right: -68px; top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path fill="#915c37" d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill="#915c37" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></i></a>';
                        } ?>
                    </li>
                    <li class="nav-item">
                        <a class="legend" href="duvidas.php"><small style="font-size: 15.4px; position: absolute; right: -130px; top: 3px;">Ajuda</small>
                            <i class="bi bi-question-circle" style="position: absolute; right: -122px; top: -45.5px; font-size: 39px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                                </svg>
                            </i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
            <a class="legend2" href="eventos.php"><small style="font-size: 15px; position: relative; right: 315px; top: 55px;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 320px; top: 15px;"></i></a>

            <body>
                <section class="add-ponto">
                    <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
                    <p>
                        <?php
                        include("util/mensagens.php");
                        include("util/tempoMsg.php");
                        ?>
                    </p>
                    <div class="container-form">

                        <form class="form" enctype="multipart/form-data" action="salvarEvento.php" method="post">
                            <h3 class="" style="color: #000; text-align: center;">ADICIONE UM EVENTO</h3>
                            <div class="inputform2">
                                <input type="text" placeholder="Nome" name="nome_evento" id="id_evento">
                            </div>
                            <div class="inputEv" style="border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #915c37; border-top: 2px solid transparent; padding: 0.5rem; ">
                                <label for="ponto" style="color: #814a23;">Ponto Referencial</label>
                                <select class="selectEv" id="id_ponto" name="id_ponto" style="border: none; outline: none; align-items: center; background-color: #d3beaf;" required>
                                    <option value="">Selecione um ponto cultural</option>
                                    <?php
                                    $pontos = obterPontosCulturais();
                                    foreach ($pontos as $ponto) {
                                        echo '<option value="' . $ponto['id_ponto'] . '">' . $ponto['nome_ponto'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="inputform2 data">
                                <input type="text" placeholder="Data do Evento (DD/MM/AAAA)" minlength="8" maxlength="10" id="id_data" name="data_evento" style="color: #000" required>
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
                                        var dataFormatada = ano + '-' + mes + '-' + dia;

                                        return dataFormatada;
                                    } else {
                                        return data;
                                    }
                                }
                            </script>
                            <div class="inputform2">
                                <input type="text" placeholder="Horário (HH:mm)" id="id_horario" name="horario" style="color: #000" required>
                            </div>
                            <script>
                                function formatTime() {
                                    var date = new Date();
                                    var hours = date.getHours();
                                    var minutes = date.getMinutes();
                                    hours = hours < 10 ? '0' + hours : hours;
                                    minutes = minutes < 10 ? '0' + minutes : minutes;
                                    var strTime = hours + ':' + minutes;
                                    document.getElementById('id_horario').value = strTime;
                                }

                                window.onload = formatTime;
                            </script>
                            <div class="inputform2 categoria" style="border-radius: 2px; border: none; outline: none; margin-top: 0.5rem; align-items: center; display: flex; border-bottom: 2px solid #915c37; border-top: 2px solid transparent; padding: 0.5rem; ">
                                <label for="categoria" style="color: #814a23;">Categoria</label>
                                <select id="categoria" name="categoria" style="border: none; outline: none; align-items: center; margin-left: 44px; background-color: #d3beaf;" required>
                                    <option value="" selected>Selecione</option>
                                    <option value="1">Eventos no Geral</option>
                                    <option value="2">Teatro</option>
                                    <option value="3">Dança</option>
                                    <option value="4">Literatura</option>
                                    <option value="5">Música</option>
                                    <option value="6">Política</option>
                                    <option value="7">Esporte</option>
                                    <option value="8">Manifestações Religiosas</option>
                                    <option value="9">Entretenimento/Cinema</option>
                                    <option value="10">Shows</option>
                                    <option value="11">Debates</option>
                                </select>
                            </div>
                            <div class="inputform2 textarea">
                                <textarea placeholder="Descrição" name="descricao_evento" rows="5" cols="21" style="width: 100%; border-radius: 2px; border: none; outline: none; margin-top: -0.5rem; align-items: center; display: flex; border-bottom: 2px solid #d3beaf; border-top: 2px solid transparent; padding: 0.5rem; "></textarea>
                            </div>
                            <p>
                                </br>
                                </br>
                            </p>
                            <button type="submit" class="button2" style="position: absolute; margin-top: -40px; margin-left: 89px; left: 665px; width: 350px;">Adicionar</button>
                        </form>
                    </div>
                </section>
                <footer id="contato">
                    <p>
                        </br>
                        </br>
                    </p>
                    <div class="py-4">
                    <div class="row">
                        <div class="col-md-7 align-self-center text-md-left text-right">
                        <p style="width: 308px; margin-left: 550px;">©Todos os direitos reservados.</p>
                        <ul>
                            <li style="color: #bda18e; font-size: 15px; text-align: center; margin-top: -12px;">
                            Equipe ARQ Cultura
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
                </footer>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="js/main.js"></script>
            </body>

</html>