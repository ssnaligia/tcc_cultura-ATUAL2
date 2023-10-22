<?php
session_start();

if (isset($_GET['msg'])) {
  $errorMsg = $_GET["msg"];
  $_SESSION["msg"] = $errorMsg;
  $_SESSION["tipo_msg"] = "alert-danger";
  header("Location: cadastro.php");
  exit();
}
?>