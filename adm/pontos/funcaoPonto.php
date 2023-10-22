<?php
require("../../sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
    $email = $_SESSION['usuario_logado'];
    buscarNomeUser($email);
}

if (isset($_POST['aprov'])) {
    $id_ponto = $_POST["id_ponto"];
    $conexao = obterConexao();
    $sql = "UPDATE PontosCulturais SET aprovado = 1 WHERE id_ponto = $id_ponto";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        $_SESSION["msg"] = "O Ponto Cultural foi aprovado!";
        $_SESSION["tipo_msg"] = "alert-success";
        header("Location: validarPontos.php");
        die();
    } else {
        $_SESSION["msg"] = "Ops! Algo deu errado, tente novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: verPonto.php");
        die();
    }
} elseif (isset($_POST['apag'])) {
    $id_ponto = $_POST["id_ponto"];
    $conexao = obterConexao();
    
    $sql_delete_eventos = "DELETE FROM Eventos WHERE id_ponto = $id_ponto";
    $result_delete_eventos = mysqli_query($conexao, $sql_delete_eventos);

    $sql_delete_imagens= "DELETE FROM Imagens WHERE id_ponto = $id_ponto";
    $result_delete_imagens = mysqli_query($conexao, $sql_delete_imagens);
        
    if ($result_delete_eventos) {
        // Agora você pode excluir o ponto cultural
        $sql_delete_ponto = "DELETE FROM PontosCulturais WHERE id_ponto = $id_ponto";
        $result_delete_ponto = mysqli_query($conexao, $sql_delete_ponto);
        
        if ($result_delete_ponto) {
            $_SESSION["msg"] = "O Ponto Cultural foi apagado!";
            $_SESSION["tipo_msg"] = "alert-success";
            header("Location: validarPontos.php");
            die();
        } else {
            $_SESSION["msg"] = "Ops! Algo deu errado ao apagar o ponto cultural, tente novamente.";
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location: verPonto.php");
            die();
        }
    } else {
        $_SESSION["msg"] = "Ops! Algo deu errado ao apagar os eventos relacionados, tente novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: verPonto.php");
        die();
    }
}
