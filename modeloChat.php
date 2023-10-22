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
    <style>
        .chat-messages {
            max-height: 1200px;
            overflow-y: auto;
        }
    </style>
    <a class="legend2" href="comunidade.php"><small style="font-size: 15px; position: absolute; right: 45px; top: 35px;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 50px; top: -5px;"></i></a>
</header>

<body style="background-color: #ede1d8; display: flex; flex-direction: column; justify-content: center;">
    <section>
        <div class="container py-5 ">

            <div class="row d-flex justify-content-center ">
                <div class="col-md-8 col-lg-6 col-xl-4 ">

                    <div class="card ">
                        <div class="card-header d-flex justify-content-between align-items-center p-3 " style="border-top: 4px solid #915c37; ">
                            <h5 class="mb-0 ">Chat</h5>
                            <div class="d-flex flex-row align-items-center ">
                                <span class="badge me-3 " style="background-color: #915c37; "></span>
                                <i class="fas fa-minus me-3 text-muted fa-xs "></i>
                                <i class="fas fa-comments me-3 text-muted fa-xs "></i>
                                <i class="fas fa-times text-muted fa-xs "></i>
                            </div>
                        </div>
                        <div class="card-body chat-messages" id="chat-container" data-mdb-perfect-scrollbar="true" style="position: relative; max-height: 400px; min-height: 400px; overflow-y: auto;">
                            <?php
                            require_once("database/conecta_bd.php");

                            // Obtém o nome do usuário atual da sessão (substitua 'usuario_logado' pelo nome de sua chave na sessão)
                            $nomeUsuarioAtual = buscarNomeUser($email);
                            //var_dump($nomeUsuarioAtual);
                            //die();

                            $sql = "SELECT c.nome AS nome_usuario, ch.data_hora, ch.mensagens FROM Chat ch
                                    INNER JOIN Cadastro c ON ch.email = c.email
                                    ORDER BY ch.data_hora ASC";

                            $conexao = obterConexao();
                            $resultado = mysqli_query($conexao, $sql);

                            if (mysqli_num_rows($resultado) > 0) {
                                while ($row = mysqli_fetch_assoc($resultado)) {
                                    $nome = $row['nome_usuario'];
                                    $dataHora = date('d/m/Y - H:i', strtotime($row['data_hora']));
                                    $mensagem = $row['mensagens'];
                            ?>
                                    <div class="d-flex justify-content-between <?php echo ($nome != $nomeUsuarioAtual) ? 'outro' : ''; ?>">
                                        <div class="<?php echo ($nome === $nomeUsuarioAtual) ? 'ms-auto' : ''; ?>">
                                            <p class="small mb-1 text-muted"><?php echo $dataHora; ?></p>
                                        </div>
                                        <h4 class="small"><?php echo $nome; ?></h4>
                                    </div>
                                    <div class="d-flex flex-row <?php echo ($nome === $nomeUsuarioAtual) ? 'justify-content-end' : 'justify-content-start'; ?>">
                                        <?php if ($nome === $nomeUsuarioAtual) { ?>
                                            <div>
                                                <p class="small p-2 mb-3 rounded-1" style="background-color: #f5f6f7;"><?php echo $mensagem; ?></p>
                                            </div>
                                            <i class="uil uil-user" style="/* width: 75px; */ height: 100%; font-size: 25px;"></i>
                                        <?php } else { ?>
                                            <i class="uil uil-user" style="/* width: 75px; */ height: 100%; font-size: 25px;"></i>
                                            <div>
                                                <p class="small p-2 mb-3 rounded-1" style="background-color: #f5f6f7;"><?php echo $mensagem; ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>

                            <?php
                                }
                            } else {
                                echo "<p style='text-align: center;'></p>";
                            }

                            // Fechar a conexão com o banco de dados
                            mysqli_close($conexao);
                            ?>
                        </div>
                        <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3" style="display: flex !important; flex-direction: column-reverse; align-items: stretch !important;">
                            <form class="chat-input" action="server.php" method="POST">
                                <div class="input-group mb-0 ">
                                    <input type="text " class="form-control" id="user-input" name="user-message" placeholder="Digite sua mensagem" aria-label="Recipient 's username" aria-describedby="button-addon2" />
                                    <button class="btn text-white" type="submit" id="button-addon2" style="padding-top: 0.25rem; background-color: #915c37; height: 100% !important; margin: 0 !important;">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!--  <script>
        // Defina um intervalo para recarregar a página a cada 5 segundos (ou o intervalo desejado)
        setInterval(function() {
            location.reload(); // Recarregue a página
        }, 5000); // 5000 milissegundos = 5 segundos (ajuste conforme necessário)
    </script> -->
    <script>
        // Obtém o elemento que contém as mensagens do chat
        const chatMessages = document.querySelector('.chat-messages');
        const messageForm = document.querySelector('.chat-input');

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Role o chat para baixo automaticamente na inicialização
        scrollToBottom();

        // Adicione um ouvinte de eventos para o envio de mensagens
        messageForm.addEventListener('submit', function(e) {

            // Aqui, você pode adicionar código para enviar a mensagem ao servidor

            // Role o chat para baixo automaticamente após o envio da mensagem
            scrollToBottom();
            setInterval(function() {
                location.reload(); // Recarregue a página
            }, 5000);
        });
    </script>
</body>

</html>