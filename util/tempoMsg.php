<?php
if (isset($_SESSION["msg"]) && !empty($_SESSION["msg"])) {
    echo "<script>
        var mensagemDiv = document.getElementById('mensagem');
        mensagemDiv.innerHTML = '" . $_SESSION["msg"] . "';
        mensagemDiv.className = 'alert " . $_SESSION["tipo_msg"] . "';
        mensagemDiv.style.display = 'block';
        setTimeout(function() {
            mensagemDiv.style.display = 'none';
        }, 5000);
    </script>";
}
