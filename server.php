<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}

$conexao = obterConexao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["user-message"])) {
        $msg_usuario = $_POST["user-message"];

        // Agora você tem a mensagem do usuário em $msg_usuario

        // Certifique-se de que $nome contenha o nome do usuário
        $email = $_SESSION['usuario_logado'];
        $nome = buscarNomeUser($email); // Substitua isso pela função que busca o nome do usuário

        // Usar declaração preparada para evitar SQL Injection
        $sql = "INSERT INTO Chat (email, mensagens, data_hora) VALUES (?, ?, NOW())";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $email, $msg_usuario);

        if ($stmt->execute()) {
            header("Location: modeloChat.php");
            die();
        } else {
            echo "Erro ao armazenar a mensagem do usuário: " . $conexao->error;
        }
    } else {
        echo "Campo 'user-message' não foi enviado.";
    }
} else {
    echo "Acesso inválido.";
}
?>