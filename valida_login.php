<?php
session_start();
require("sistema_bd.php");

$email = $_POST["email"];
$senha = $_POST["senha"];
$lembrar = isset($_POST["lembrar"]) ? $_POST["lembrar"] : 0;

if ($lembrar == 1) {
    setcookie('username', $email, time() + 120, "/");
}

$dados_consulta = buscarUsuario($email, $senha);
$usuario = $dados_consulta[0];

if ($usuario == NULL && $dados_consulta[1] == "Usuário incorreto!") {
    $msgErro = "Usuário incorreto ou inexistente!";
} elseif ($usuario == NULL && $dados_consulta[1] == "Senha incorreta!") {
    $msgErro = "Senha incorreta!";
} elseif ($usuario == NULL && $dados_consulta[0]["id_confirmaEmail"] != 1) {
    $msgErro = "Seu email ainda não foi verificado, verifique sua caixa de entrada!";
} 

if (isset($msgErro)) {
    $saida = ["autenticado" => false, "msg" => $msgErro];
    header("Refresh: 0; url=login.php");
    $_SESSION["msg"] = $msgErro;
    $_SESSION["tipo_msg"] = "alert-danger";
} else {
    $saida = ["autenticado" => true, "perfil" => $usuario["id_tipo"], "primeiroLogin" => $usuario["primeiroLogin"]];
    $_SESSION["logado"] = 1;
    $_SESSION["usuario_logado"] = $usuario["email"];
    $_SESSION["verificacao"] = $usuario["id_tipo"];

    $json = json_encode($saida);
    echo $json;
}
?>