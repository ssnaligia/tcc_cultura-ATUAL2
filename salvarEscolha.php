<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_SESSION['usuario_logado'];
    $conexao = obterConexao();

    // Itere pelos eventos para obter as escolhas
    foreach ($_POST['eventoSelect'] as $id_evento => $escolha) {
        // Certifique-se de validar e sanitizar os valores, pois eles vêm dos dados do formulário
        $id_evento = (int) $id_evento;
        $escolha = mysqli_real_escape_string($conexao, $escolha);

        // Verifique se o usuário já fez uma escolha para o evento
        $sqlVerificarEscolha = "SELECT id_escolha FROM EscolhasUsuario WHERE email = ? AND id_evento = ?";
        $stmtVerificarEscolha = $conexao->prepare($sqlVerificarEscolha);
        $stmtVerificarEscolha->bind_param("si", $email, $id_evento);
        $stmtVerificarEscolha->execute();
        $resultVerificarEscolha = $stmtVerificarEscolha->get_result();

        if ($resultVerificarEscolha->num_rows > 0) {
            $row = $resultVerificarEscolha->fetch_assoc();
            $id_escolha = $row['id_escolha'];

            $sqlExcluirEscolha = "DELETE FROM EscolhasUsuario WHERE id_escolha = ?";
            $stmtExcluirEscolha = $conexao->prepare($sqlExcluirEscolha);
            $stmtExcluirEscolha->bind_param("i", $id_escolha);
            $stmtExcluirEscolha->execute();
        }

        // Insira a nova escolha do usuário para o evento
        $sqlInserirEscolha = "INSERT INTO EscolhasUsuario (email, id_evento, escolha) VALUES (?, ?, ?)";
        $stmtInserirEscolha = $conexao->prepare($sqlInserirEscolha);

        if ($stmtInserirEscolha) {
            $stmtInserirEscolha->bind_param("sis", $email, $id_evento, $escolha);
            $stmtInserirEscolha->execute();
        }
    }

    header("Location: eventos.php");
}
?>
