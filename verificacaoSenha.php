<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("database/conecta_bd.php");
require("sistema_bd.php");

if (isset($_SESSION['logado'])) {
    $redirecionarUsuario = 0;
} else {
    $redirecionarUsuario = 1;
}
if (isset($_POST["senha"])) {
    $senha = $_POST["senha"];
    $email = $_SESSION["usuario_logado"];
    $senha_md5 = md5($senha);
    function alterarSenha($senha_md5, $email, $redirecionarUsuario) {
        // Consulta SQL para obter a senha armazenada no banco
        $sql = "SELECT senha FROM Cadastro WHERE email = ?";
        $conexao = obterConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($senha_armazenada);
        $stmt->fetch();
        if ($senha_md5 === $senha_armazenada) {
            // A senha atual fornecida é igual à senha armazenada no banco
            header("Location: trocarSenha.php");
            $_SESSION["msg"] = "A senha atual é a mesma que a antiga.";
            $_SESSION["tipo_msg"] = "alert-danger";
        } else {
            // A senha atual fornecida é diferente da senha armazenada no banco
            // Atualiza a senha no banco de dados
            $sql = "UPDATE Cadastro SET senha = ? WHERE email = ?";
            $conexao = obterConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss", $senha_md5, $email);
            if ($stmt->execute()) {
                // Senha alterada com sucesso
                if ($redirecionarUsuario == 1) {
                    $_SESSION["msg"] = "Senha alterada com sucesso! Faça login em sua conta.";
                    $_SESSION["tipo_msg"] = "alert-success";
                    header("Location: login.php");
                    die();
                } else {
                    $_SESSION["msg"] = "Senha alterada com sucesso!";
                    $_SESSION["tipo_msg"] = "alert-success";
                    header("Location: perfil.php");
                    die();
                }
            } else {
                // Ocorreu um erro ao atualizar a senha
                $_SESSION["msg"] = "Erro ao alterar a senha. Por favor, tente novamente.";
                $_SESSION["tipo_msg"] = "alert-danger";
                header("Location: trocarSenha.php");
                die();
            }
        }
    }

    alterarSenha($senha_md5, $email, $redirecionarUsuario);
}
?>