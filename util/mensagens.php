<?php
function exibirMsg() {
  $mensagem = "";
  if (!empty($_SESSION["msg"])) {
    $mensagem = $_SESSION["msg"];
    if (!empty($_SESSION["tipo_msg"])) {
      $tipo_msg = $_SESSION["tipo_msg"];
    }
    
    // Exiba a mensagem
    if (!empty($mensagem)) :
?>
    <p class="alert <?= $tipo_msg ?> text-center" style="padding: 3px; size: 5px; text-align: center;">
      <?= $mensagem ?>
    </p>
<?php
    endif;

    // Limpe a variável de sessão
    unset($_SESSION["msg"]);
  }
}
?>
