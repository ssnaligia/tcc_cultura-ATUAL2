<?php
require("sistema_bd.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $categoria = $_POST["categoria"];
    $filtro_categoria = !empty($categoria) ? " WHERE p.categoria = " . (int)$categoria : "";
    $sql = "SELECT p.id_ponto, p.nome_ponto, p.descricao, p.endereco, i.diretorio_imagem 
            FROM PontosCulturais p
            LEFT JOIN Imagens i ON p.id_ponto = i.id_ponto" . $filtro_categoria;
    $conexao = obterConexao();
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        while ($ponto = $resultado->fetch_assoc()) {
            $descricao = $ponto['descricao'];
            $descricao_exibicao = strlen($descricao) > 150 ? substr($descricao, 0, 150) . '...' : $descricao;

            echo '<article>';
            echo '    <div class="article-wrapper">';
            echo '        <figure>';
            echo '            <img src="' . $ponto['diretorio_imagem'] . '" alt="Imagem do ponto" />';
            echo '        </figure>';
            echo '        <div class="article-body">';
            echo '            <h2>' . $ponto['nome_ponto'] . '</h2>';
            echo '            <h5>' . $ponto['endereco'] . '</h5>';
            echo '            <p style="word-wrap: break-word;">' . $descricao_exibicao . '</p>'; // Estilo adicionado aqui
            echo '    <div class="read-more">';
            echo '        <a style="text-decoration: none;" href="detalhes_ponto.php?id=' . $ponto['id_ponto'] . '">Ver mais</a>';
            echo '    </div>';
            echo '</div>';
            echo '    </div>';
            echo '</article>';
        }
    } else {
        echo '<p class="aviso">Nenhum ponto cultural encontrado para a categoria selecionada.</p>';
    }

    $conexao->close();
}
?>
