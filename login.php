<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<header>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ARQ Cultura</title>
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  <a class="legend2" href="index.php"><small style="font-size: 15px; position: absolute; right: 645px; top: 35px;">Voltar</small><i class="uil uil-arrow-left" style="font-size: 35px; position: absolute; right: 650px; top: -5px;"></i></a>
</header>

<body class="body-login">
  <div class="container-login">
    <div id="mensagem" style="padding: 3px; size: 5px; text-align: center;"></div>
    <p>
      <?php
      include("util/mensagens.php");
      include("util/tempoMsg.php");
      ?>
    </p>
    <div class="forms">
      <div class="form-login">
        <p><span class="title">Login</span></p>
        <form id="form_login" method="post" action="valida_login.php">
          <div class="input-field">
            <input type="email" placeholder="Email" id="id_email" name="email" value="<?php if (isset($_COOKIE['username']) == true) {
                                                                                        echo $_COOKIE['username'];
                                                                                      } ?>" required>
            <i class="uil uil-envelope icon"></i>
          </div>
          <div class="input-field">
            <input type="password" class="password" placeholder="Senha" id="id_senha" name="senha" minlength="8" maxlength="12" required>
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
          </div>
          <input type="checkbox" name="lembrar" id="logCheck" style="margin-left: 2.5%;" value="1" checked <?php if (isset($_COOKIE["username"]) && isset($_SESSION["usuario_logado"]) && $_SESSION["usuario_logado"]) { ?> checked <?php } ?>>
          <label for="logCheck" class="text text-check" style="margin-top: 7%;">Manter Conectado</label>
          <a href="esqueci_senha.php" class="text" style="margin-left: 12%;">Esqueceu sua senha?</a>
          <div class="text-center text-danger pt-3" id="id_msg"></div>
          <button type="submit" class="button-login input-field" style="text-align: center; background-color: #915c37; border: none; color: #fff; font-size: 17px; font-weight: 500; letter-spacing: 1px; border-radius: 6px; padding: .5rem 9.5rem;" id="btn_login">Entrar</button>
        </form>
        <div class="login-signup">
          <span class="text">Não tem uma conta?
            <a href="cadastro.php" class="text signup-text">Cadastre-se!</a>
          </span>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.addEventListener("load", setEventos);

    function setEventos() {
      let button = document.getElementById('btn_login');
      button.addEventListener("click", validarLogin);

      document.getElementById("id_email").addEventListener("focus", limparCampo);
      document.getElementById("id_senha").addEventListener("focus", limparCampo);
      document.getElementById("logCheck").addEventListener("focus", limparCampo);
    }

    function validarLogin() {
      let email = document.getElementById("id_email").value;
      let senha = document.getElementById("id_senha").value;
      let lembrar = document.getElementById("logCheck").value;
      let dados_form = new FormData();
      dados_form.append("email", email);
      dados_form.append("senha", senha);
      dados_form.append("lembrar", lembrar);

      fetch("valida_login.php", {
          method: 'POST',
          body: dados_form,
        })
        .then(function(response) {
          if (!response.ok) {
            throw new Error(response.statusText);
          }
          return response.json();
        })
        .then(function(objeto) {
          if (objeto.autenticado) {
            if (objeto.perfil == 1) {
              window.location.href = "adm/pontos/validarPontos.php";
            } else if (objeto.primeiroLogin == 1) {
              window.location.href = "preferencias.php";
            } else {
              window.location.href = "index.php";
            }
          } else {
            exibirMensagemErro(objeto.msg);
          }
        })
        .catch(function(erro) {
          exibirMensagemErro("Erro na requisição");
          console.error(erro);
        });
    }

    function limparCampo() {
      document.getElementById("id_msg").innerHTML = "";
    }

    <?php if (isset($_SESSION['msg'])) : ?>
      exibirMensagemErro("<?php echo $_SESSION['msg']; ?>");
      <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>
  </script>


  <script src="js/scriptLogin.js"></script>
</body>

</html>