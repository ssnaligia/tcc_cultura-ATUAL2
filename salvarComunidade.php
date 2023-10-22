<?php
require("sistema_bd.php");

$nome_com = $_POST['nome_comunidade'];
$idade_min = $_POST['idade_minima'];
$descricao_com = $_POST['descricao_comunidade'];

inserirComunidade($nome_com, $idade_min, $descricao_com);
?>