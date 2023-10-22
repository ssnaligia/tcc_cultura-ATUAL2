<?php
session_start();
require("sistema_bd.php");

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_ponto"];
    $endereco = $_POST["endereco"];
    $categoria = $_POST["categoria"];
    $descricao = $_POST["descricao"];

    $id_ponto = inserirPonto($nome, $endereco, $descricao, $categoria);

    // Verifica se o ID do ponto é válido
    if ($id_ponto !== null) {
        // Continua com o processo de salvar a imagem
        if (isset($_FILES['imagens']) && $_FILES['imagens']['error'] === UPLOAD_ERR_OK) {
            $nome_temporario = $_FILES['imagens']['tmp_name'];
            $nome_arquivo = $_FILES['imagens']['name'];
            $diretorio_destino = "imgsPontos/" . $nome_arquivo;

            // Move o arquivo para o diretório desejado
            if (move_uploaded_file($nome_temporario, $diretorio_destino)) {
                // Salva o diretório no banco de dados
                $conexao = obterConexao();
                $diretorio_salvo = mysqli_real_escape_string($conexao, $diretorio_destino);
                $sql = "INSERT INTO Imagens (id_ponto, diretorio_imagem) VALUES ('$id_ponto', '$diretorio_salvo')";
                mysqli_query($conexao, $sql);
                mysqli_close($conexao);
                header("Location: mostrarPontos.php");
            } else {
                $_SESSION["msg"] = "Erro ao salvar a imagem.";
                $_SESSION["tipo_msg"] = "alert-danger";
                header("Location: pontosCulturais.php");
            }
        } else {
            $_SESSION["msg"] = "Erro ao enviar a imagem.";
            $_SESSION["tipo_msg"] = "alert-danger";
            /* header("Location: pontosCulturais.php"); */
        }
    } else {
        $_SESSION["msg"] = "falha";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: pontosCulturais.php");
    }
}

$apiKey = "AIzaSyDe64Z2dRsH8QPQe2iPnUNS-hEl7q0JLs8";

// Codifica o endereço para que ele possa ser incluído em uma URL
$enderecoCodificado = urlencode($endereco);

// Monta a URL para a requisição à API Geocoding
$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$enderecoCodificado}&key={$apiKey}";

// Realiza a requisição
$response = file_get_contents($url);

if ($response) {
    // Decodifica a resposta JSON
    $data = json_decode($response);

    // Verifica se a solicitação teve êxito
    if ($data->status === "OK") {
        // Recupera a latitude e longitude do primeiro resultado
        $latitude = $data->results[0]->geometry->location->lat;
        $longitude = $data->results[0]->geometry->location->lng;
        $sql = "INSERT INTO Coordenadas (id_ponto, latitude, longitude) VALUES (?, ?, ?)";
        $conexao = obterConexao();
        $stmt = $conexao->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("iss", $id_ponto, $latitude, $longitude);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
            } else {
                echo "Falha ao inserir o ponto.";
            }
            $stmt->close();
        } else {
            $_SESSION["msg"] = "Erro na preparação da consulta: " . $conexao->error;
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location: pontosCulturais.php");
        }
    } else {
        echo "A solicitação à API Geocoding falhou. Status: {$data->status}";
    }
} else {
    echo "Falha na solicitação à API Geocoding.";
}
?>
