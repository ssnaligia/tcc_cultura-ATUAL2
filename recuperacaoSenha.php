<?php
if (!isset($_SESSION)) {
    session_start();
}
require("sistema_bd.php");

$email = $_POST["email"];

recuperacaoUsuario($email);
?>