<?php
require("sistema_bd.php");
$email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
$email = $_SESSION['usuario_logado'];

$criador = $email;
$nome_com = $_POST['nome_comunidade'];
$idade_min = $_POST['idade_minima'];
$descricao_com = $_POST['descricao_comunidade'];

$sql = "SELECT COUNT(*) AS count FROM Comunidade WHERE nome_comunidade = '$nome_com'";
    $conexao = obterConexao();
    $resultado = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $count = $row['count'];

    if ($count > 0) {
        $_SESSION["msg"] = "Já existe uma comunidade com esse mesmo nome!";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: addComunidade.php");       
    } else {
        inserirComunidade($criador, $nome_com, $idade_min, $descricao_com);
    }
?>