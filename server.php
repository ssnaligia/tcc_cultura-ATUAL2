<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}

$conexao = obterConexao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["user-message"])) {
        $id_comunidade = $_POST["id_comunidade"];
        $msg_usuario = $_POST["user-message"];


        $email = $_SESSION['usuario_logado'];
        $nome = buscarNomeUser($email); 
        $sql = "INSERT INTO Chat (id_comunidade, email, mensagens, data_hora) VALUES (?, ?, ?, NOW())";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("iss", $id_comunidade, $email, $msg_usuario);

        if ($stmt->execute()) {
            header("Location: modeloChat.php?id_comunidade=" . $id_comunidade);
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