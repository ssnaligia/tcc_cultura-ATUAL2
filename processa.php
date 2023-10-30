<?php
session_start();
require("sistema_bd.php");
$conexao = obterConexao();

if (isset($_POST['rating'])) {
    $rating = $_POST['rating'];
    $id_ponto = $_POST["id_ponto"];

    $query = "INSERT INTO Avaliacoes (id_ponto, qnt_estrela) VALUES (?, ?)";
    
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_ponto, $rating);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["msg"] = "Agradecemos a avaliação!";
        $_SESSION["tipo_msg"] = "alert-success";
        header("Location: mostrarPontos.php");
    } else {
        $_SESSION["msg"] = "Erro ao avaliar.";
        $_SESSION["tipo_msg"] = "alert-danger";  mysqli_error($conexao);
        header("Location: mostrarPontos.php");
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
?>