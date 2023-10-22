<?php
require("sistema_bd.php");

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtém a categoria selecionada pelo usuário
    $categoria = $_POST["categoria"];
    // A consulta SQL será modificada para incluir uma cláusula WHERE com base na categoria selecionada
    $filtro_categoria = !empty($categoria) ? " WHERE p.categoria = " . (int)$categoria : "";
    $sql = "SELECT p.id_ponto, p.nome_ponto, p.descricao, p.endereco, i.diretorio_imagem 
            FROM PontosCulturais p
            LEFT JOIN Imagens i ON p.id_ponto = i.id_ponto" . $filtro_categoria;
    $conexao = obterConexao();
    // Execute a consulta e obtenha o resultado
    $resultado = $conexao->query($sql);

    // Se houver pontos culturais correspondentes ao filtro
    if ($resultado->num_rows > 0) {
        // Loop para exibir cada ponto no formato de article-wrapper
        while ($ponto = $resultado->fetch_assoc()) {
            // Obter a descrição de cada ponto
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
            // Se quiser adicionar um link para ver mais detalhes do ponto:
            echo '    </div>';
            echo '</article>';
        }
    } else {
        echo '<p class="aviso">Nenhum ponto cultural encontrado para a categoria selecionada.</p>';
    }

    // Fechando a conexão com o banco de dados
    $conexao->close();
}
?>
