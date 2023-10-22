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
    $id_comunidade = $_POST["id_comunidade"];
    $conexao = obterConexao();
    $sql = "UPDATE Comunidade SET aprovado = 1 WHERE id_comunidade = $id_comunidade";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        $_SESSION["msg"] = "A Comunidade foi aprovada!";
        $_SESSION["tipo_msg"] = "alert-success";
        header("Location: validarComunidades.php");
        die();
    } else {
        $_SESSION["msg"] = "Ops! Algo deu errado, tente novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: verComunidade.php");
        die();
    }
} elseif (isset($_POST['apag'])) {
    $id_comunidade = $_POST["id_comunidade"];
    $conexao = obterConexao();

        $sql = "DELETE FROM Comunidade WHERE id_comunidade = $id_comunidade";
        $result_delete_comunidade = mysqli_query($conexao, $sql);
        
        if ($result_delete_comunidade) {
            $_SESSION["msg"] = "A Comunidade foi apagada!";
            $_SESSION["tipo_msg"] = "alert-success";
            header("Location: validarComunidades.php");
            die();
        } else {
            $_SESSION["msg"] = "Ops! Algo deu errado ao apagar o ponto cultural, tente novamente.";
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location: verComunidade.php");
            die();
        }
    } else {
        $_SESSION["msg"] = "Ops! Algo deu errado ao apagar os eventos relacionados, tente novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: verComunidade.php");
        die();
    }
