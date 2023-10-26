<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("database/conecta_bd.php");
require("sistema_bd.php");

$email = $_SESSION["usuario_logado"];
$chave = filter_input(INPUT_GET, "chave", FILTER_SANITIZE_STRING);

if (!empty($chave)) {
    $conexao = obterConexao();
    $sql = "SELECT email FROM Cadastro WHERE chave = ? LIMIT 1"; 
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $chave);
    $stmt->execute();
    $stmt->store_result(); 
    if ($stmt->num_rows != 0) {
        $_SESSION["msg"] = "Erro: Endereço inválido para confirmar o email. Faça o cadastro novamente!";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: login.php");
        die();
    } else {
        $stmt->bind_result($email);
        $stmt->fetch();
        $sql = "UPDATE Cadastro SET id_confirmaEmail = 1 WHERE email = ?";
        $conexao = obterConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email); 
        if ($stmt->execute()) {
            $_SESSION["msg"] = "Email confirmado!";
            $_SESSION["tipo_msg"] = "alert-success";
            header("Location: login.php");
            die();
        } else {
            $_SESSION["msg"] = "Erro: Endereço inválido para confirmar o email. Faça o cadastro novamente!";
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location: login.php");
            die();
        }
    }
} else {
    $_SESSION["msg"] = "Erro: Endereço inválido para confirmar o email. Faça o cadastro novamente!";
    $_SESSION["tipo_msg"] = "alert-danger";
    header("Location: login.php");
    die();
}
?>