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
    $id_evento = $_POST["id_evento"];
    $conexao = obterConexao();
    $sql = "UPDATE Eventos SET aprovado = 1 WHERE id_evento = $id_evento";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        $_SESSION["msg"] = "O Evento foi aprovado!";
        $_SESSION["tipo_msg"] = "alert-success";
        header("Location: validarEventos.php");
        die();
    } else {
        $_SESSION["msg"] = "Ops! Algo deu errado, tente novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: verEvento.php");
        die();
    }
} elseif (isset($_POST['apag'])) {
    $id_evento = $_POST["id_evento"];
    $conexao = obterConexao();
    
        $sql = "DELETE FROM Eventos WHERE id_evento = $id_evento";
        $result_delete_evento = mysqli_query($conexao, $sql);
        
        if ($result_delete_evento) {
            $_SESSION["msg"] = "O Evento foi apagado!";
            $_SESSION["tipo_msg"] = "alert-success";
            header("Location: validarEventos.php");
            die();
        } else {
            $_SESSION["msg"] = "Ops! Algo deu errado ao apagar o ponto cultural, tente novamente.";
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location: verEvento.php");
            die();
        }
    } else {
        $_SESSION["msg"] = "Ops! Algo deu errado ao apagar os eventos relacionados, tente novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: verEvento.php");
        die();
    }
