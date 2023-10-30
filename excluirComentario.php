<?php
require_once("database/conecta_bd.php");

if (isset($_GET['id'])) {
    $idComentario = $_GET['id'];

    $conexao = obterConexao();

    $sql = "DELETE FROM Comentarios WHERE id_comentario = $idComentario";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado) {
        header("Location: mostrarPontos.php?id_ponto=$id_ponto#areaComentarios");
        exit();
    } else {
        echo "Erro ao excluir o comentário.";
    }

    mysqli_close($conexao);
}
