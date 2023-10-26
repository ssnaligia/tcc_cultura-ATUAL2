<?php
require_once("database/conecta_bd.php");
$email = $_POST["email"];

if(isset($_POST['btn_select'])) {
    $brands = $_POST['categorias'];
    foreach($brands as $item) {
        $conexao = obterConexao();
        $query = "INSERT INTO Preferencias (email, categoria) VALUES ('$email','$item')";
        $query_run = mysqli_query($conexao, $query);
    }

    if($query_run == true) {
        $conexao = obterConexao();
        $query_update = "UPDATE Cadastro SET primeiroLogin = FALSE WHERE email = '$email'";
        $query_update_run = mysqli_query($conexao, $query_update);

        if($query_update_run) {
            $_SESSION["msg"] = "Preferências cadastradas com sucesso!";
            $_SESSION["tipo_msg"] = "alert-success";
            header("Location: notificacoes.php");    
        } else {
            $_SESSION["msg"] = "Erro ao atualizar o campo primeiro_login!";
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location: preferencias.php");
        }
    } else {
        $_SESSION["msg"] = "Erro ao cadastrar as preferências!";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: preferencias.php");    
    }
}
?>