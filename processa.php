<?php
session_start();
require("sistema_bd.php");
$conexao = obterConexao();
if (isset($_POST['rating'])) {
    $rating = $_POST['rating'];
    
    $query = "INSERT INTO Avaliacoes (qnt_estrela) VALUES (?)";
    
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "i", $rating);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Avaliação salva com sucesso!";
    } else {
        echo "Erro ao salvar a avaliação: " . mysqli_error($conexao);
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
?>