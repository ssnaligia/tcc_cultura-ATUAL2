<?php
if (!isset($_SESSION)) {
    session_start();
  }
require_once("database/conecta_bd.php");

unset($_SESSION["usuario_logado"]);
$_SESSION["logado"] = 0;
session_destroy();
header("Location: login.php");
exit;
?>