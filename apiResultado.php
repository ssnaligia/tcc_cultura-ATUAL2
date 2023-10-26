<?php
require("sistema_bd.php");

function parseToXML($htmlStr) {
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

$conexao = obterConexao();

$result_pontos_culturais = "SELECT pc.*, coord.* 
FROM PontosCulturais pc
JOIN Coordenadas coord ON pc.id_ponto = coord.id_ponto
WHERE pc.aprovado = 1;
";
$resultado_pontos_culturais = mysqli_query($conexao, $result_pontos_culturais);

header("Content-type: text/xml");

echo '<markers>';

while ($row_ponto_cultural = mysqli_fetch_assoc($resultado_pontos_culturais)) {
    $marker = array(
        'name' => $row_ponto_cultural['nome_ponto'],
        'address' => $row_ponto_cultural['endereco'],
        'lat' => (float)$row_ponto_cultural['latitude'],
        'lng' => (float)$row_ponto_cultural['longitude']
    );

    echo '<marker ';
    echo 'name="' . parseToXML($marker['name']) . '" ';
    echo 'address="' . parseToXML($marker['address']) . '" ';
    echo 'lat="' . $marker['lat'] . '" ';
    echo 'lng="' . $marker['lng'] . '" ';
    echo '/>';
}

echo '</markers>';
