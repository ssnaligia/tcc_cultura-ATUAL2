<?php
require("sistema_bd.php");

$nome = $_POST["nome"];
$telefone = $_POST["telefone"];
$data = $_POST["data_nasc"];
$email = $_POST["email"];
$categorias = $_POST["categorias"]; 

alterarPerfil($nome, $telefone, $data, $email);

// Atualiza as preferências do usuário no banco de dados
atualizarPreferenciasUsuario($email, $categorias);

header("Location: formAlterarPerfil.php");
exit();
?>