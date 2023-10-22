<?php
$previousPage = $_SERVER['HTTP_REFERER'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQA Cultura</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://use.typekit.net/qbi8cck.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

</header>

<a class="legend2" href="<?php echo $previousPage; ?>"><small style="font-size: 15px; position: absolute; right: 1545px; top: 185px; color: #915c37;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 1550px; top: 148px; color: #915c37;"></i></a>


<body style="overflow-y: hidden; ">
    <section class="faq-container">
        <h3 class="faq-titulo">Perguntas frequentes</h3>

        <div class="faq">
            <div class="pergunta">
                <h3>Todas as minhas atividades criadas (como Pontos Culturais ou Eventos) são incluídas diretamente no Sistema?</h3>
                <i class="uil uil-angle-down"></i>
            </div>

            <div class="resposta">
                <p>Não! As informações são enviadas para uma análise, e se caso forem aprovadas por algum administrador, ficam disponíveis para todos.</p>
            </div>

            <div class="pergunta">
                <h3>É possível divulgar meu trabalho na plataforma?</h3>
                <i class="uil uil-angle-down"></i>
            </div>

            <div class="resposta">
                <p>Ainda não, mas em um futuro próximo será possível a divulgação de projetos por artistas autônomos.</p>
            </div>

            <div class="pergunta">
                <h3>Consigo falar diretamente com os administradores?</h3>
                <i class="uil uil-angle-down"></i>
            </div>

            <div class="resposta">
                <p>Sim! Ao final da página Home existe um portal de dúvidas, na qual você pode mandar um email diretamente para EQUIPE ARQ.</p>
            </div>
        </div>
    </section>
</body>
<script defer src="js/script.js"></script>

</html>