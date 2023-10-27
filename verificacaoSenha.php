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
        $sql = "SELECT senha FROM Cadastro WHERE email = ?";
        $conexao = obterConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($senha_armazenada);
        $stmt->fetch();
        if ($senha_md5 === $senha_armazenada) {
            header("Location: trocarSenha.php");
            $_SESSION["msg"] = "A senha atual é a mesma que a antiga.";
            $_SESSION["tipo_msg"] = "alert-danger";
        } else {
            $sql = "UPDATE Cadastro SET senha = ? WHERE email = ?";
            $conexao = obterConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss", $senha_md5, $email);
            if ($stmt->execute()) {
                if ($redirecionarUsuario == 1) {
                    $_SESSION["msg"] = "Senha alterada com sucesso! Faça login em sua conta.";
                    $_SESSION["tipo_msg"] = "alert-success";
                    header("Location: login.php");
                    die();
                } else {
                    $_SESSION["msg"] = "Senha alterada com sucesso!";
                    $_SESSION["tipo_msg"] = "alert-success";
                    header("Location: perfil2.php");
                    die();
                }
            } else {
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