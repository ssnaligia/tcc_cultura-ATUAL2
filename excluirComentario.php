<?php
require_once("database/conecta_bd.php");

if (isset($_GET['id'])) {
    $idComentario = $_GET['id'];

    // Conectar ao banco de dados
    $conexao = obterConexao();

    // Excluir o comentário
    $sql = "DELETE FROM Comentarios WHERE id_comentario = $idComentario";
    $resultado = mysqli_query($conexao, $sql);

    // Verificar se a exclusão foi bem-sucedida
    if ($resultado) {
        // Redirecionar de volta à página de exibição de comentários
        header("Location: pontosCulturais.php");
        exit();
    } else {
        // Tratar erro na exclusão do comentário
        echo "Erro ao excluir o comentário.";
    }

    // Fechar a conexão com o banco de dados
    mysqli_close($conexao);
}
