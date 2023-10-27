<?php
require("sistema_bd.php");
$email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
$email = $_SESSION['usuario_logado'];

$criador = $email;
$nomeEvento = $_POST['nome_evento'];
$pontoRef = $_POST['id_ponto'];
$dataEvento = $_POST['data_evento'];
$dataEventoFormatada = DateTime::createFromFormat('d/m/Y', $dataEvento)->format('Y-m-d');
$horarioEvento = $_POST['horario'];
$categoria = $_POST['categoria'];
$descricaoEvento = $_POST['descricao_evento'];

    $sql = "SELECT COUNT(*) AS count FROM Eventos WHERE nome_evento = '$nomeEvento'";
    $conexao = obterConexao();
    $resultado = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $count = $row['count'];

    if ($count > 0) {
        $_SESSION["msg"] = "Já existe um evento com esse mesmo nome!";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: cadastroEvento.php");       
    } else {
        inserirEvento($criador, $nomeEvento, $pontoRef, $dataEventoFormatada, $horarioEvento, $categoria, $descricaoEvento);
    }
?>