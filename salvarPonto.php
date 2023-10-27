<?php
session_start();
require("sistema_bd.php");
$email1 = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == true;
$email = $_SESSION['usuario_logado'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $criador = $email;
    $nome = $_POST["nome_ponto"];

    // Consulta para verificar se o ponto cultural já existe
    $sql = "SELECT COUNT(*) AS count FROM PontosCulturais WHERE nome_ponto = '$nome'";
    $conexao = obterConexao();
    $resultado = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $count = $row['count'];

    if ($count > 0) {
        $_SESSION["msg"] = "Já existe um ponto cultural com esse mesmo nome!";
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location: pontosCulturais.php");       
    } else {
        $endereco = $_POST["endereco"];
        $categoria = $_POST["categoria"];
        $descricao = $_POST["descricao"];
    
        $id_ponto = inserirPonto($criador, $nome, $endereco, $descricao, $categoria);
        $_SESSION["id_ponto"] = $id_ponto;
        
    if ($id_ponto !== null) {
        if (isset($_FILES['imagens']) && $_FILES['imagens']['error'] === UPLOAD_ERR_OK) {
            $nome_temporario = $_FILES['imagens']['tmp_name'];
            $nome_arquivo = $_FILES['imagens']['name'];
            $diretorio_destino = "imgsPontos/" . $nome_arquivo;

            if (move_uploaded_file($nome_temporario, $diretorio_destino)) {
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
}

$apiKey = "AIzaSyDe64Z2dRsH8QPQe2iPnUNS-hEl7q0JLs8";

$enderecoCodificado = urlencode($endereco);

$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$enderecoCodificado}&key={$apiKey}";

$response = file_get_contents($url);

if ($response) {
    $data = json_decode($response);

    if ($data->status === "OK") {
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
