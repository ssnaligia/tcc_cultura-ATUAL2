<?php
require("sistema_bd.php");

$nomeEvento = $_POST['nome_evento'];
$pontoRef = $_POST['id_ponto'];
$dataEvento = $_POST['data_evento'];
$dataEventoFormatada = DateTime::createFromFormat('d/m/Y', $dataEvento)->format('Y-m-d');
$horarioEvento = $_POST['horario'];
$categoria = $_POST['categoria'];
$descricaoEvento = $_POST['descricao_evento'];

inserirEvento($nomeEvento, $pontoRef, $dataEventoFormatada, $horarioEvento, $categoria, $descricaoEvento);
?>