<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}

$email = $_SESSION['usuario_logado'];
$comentario = $_POST["comentario"];
$id_ponto = $_POST["id_ponto"];

inserirComentario($id_ponto, $comentario, $email);
?>