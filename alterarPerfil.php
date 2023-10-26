<?php
require("sistema_bd.php");

$nome = $_POST["nome"];
$telefone = $_POST["telefone"];
$data = $_POST["data_nasc"];
$email = $_POST["email"];
$categorias = $_POST["categorias"]; 

alterarPerfil($nome, $telefone, $data, $email);

atualizarPreferenciasUsuario($email, $categorias);

header("Location: formAlterarPerfil.php");
exit();
?>