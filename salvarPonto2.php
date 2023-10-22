<?php
session_start();
require("sistema_bd.php");

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_ponto"];
    $endereco = $_POST["endereco"];
    $categoria = $_POST["categoria"];
    $descricao = $_POST["descricao"];

    // Inserir o ponto cultural e obter o ID do ponto inserido
    $id_ponto = inserirPonto($nome, $endereco, $descricao, $categoria);
    $_SESSION["id_ponto"] = $id_ponto;

    // Verifica se o ID do ponto é válido
    if ($id_ponto !== null) {
        // Continua com o processo de salvar as imagens
        if(isset($_FILES['imagens']) && is_array($_FILES['imagens']['name'])) {
            $diretorio_base = "imgsPontos/";

            foreach ($_FILES['imagens']['name'] as $key => $nome_arquivo) {
                $nome_temporario = $_FILES['imagens']['tmp_name'][$key];
                $diretorio_destino = $diretorio_base . $nome_arquivo;

                if(move_uploaded_file($nome_temporario, $diretorio_destino)) {
                    // Salva o diretório no banco de dados para cada imagem
                    $conexao = obterConexao();
                    $diretorio_salvo = mysqli_real_escape_string($conexao, $diretorio_destino);
                    $sql = "INSERT INTO Imagens (id_ponto, diretorio_imagem) VALUES ('$id_ponto', '$diretorio_salvo')";
                    mysqli_query($conexao, $sql);
                    mysqli_close($conexao);
                } else {
                    $_SESSION["msg"] = "Erro ao salvar a imagem $nome_arquivo.";
                    $_SESSION["tipo_msg"] = "alert-danger";
                }
            }

            header("Location: mostrarPontos.php");
        } else {
            $_SESSION["msg"] = "Erro ao enviar as imagens.";
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location: pontosCulturais.php");
        }
    } else {
        $_SESSION["msg"] = "falha";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: pontosCulturais.php");
    }
}
?>