<?php
require_once("database/conecta_bd.php");

if(isset($_POST['btn_notificacao'])) {
    if (isset($_POST["notificacoes"])) {
        $email = $_POST["email"];
        $notificacaoSelecionada = $_POST["notificacoes"];
        $conexao = obterConexao();

        $sql = "INSERT INTO Notificacoes (email, notificacao) VALUES (?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $email, $notificacaoSelecionada);

        if ($stmt->execute()) {
            header("Location: index.php");    
        } else {
            echo "Erro ao salvar a notificação: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>