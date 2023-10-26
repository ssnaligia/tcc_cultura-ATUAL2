
function validarSenha() {
  var senha = document.getElementById("id_senha").value;
  var regex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,}$/;
  if (regex.test(senha)) {
    document.getElementById("mensagem").innerHTML = "";
    document.getElementById("btn_cadastro").disabled = false;
  } else {
    document.getElementById("mensagem").innerHTML =
      "A senha deve conter pelo menos 8 caracteres contendo pelo menos: uma letra maiúscula e minúscula, um número, e um caracter especial(@$!%*?&_).";
    document.getElementById("btn_cadastro").disabled = true;
  }
}

function senhasIguais() {
  var senha = document.getElementById("id_senha").value;
  var confirmar = document.getElementById("id_confirmar").value;
  var regex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,}$/;
  if (regex.test(senha) && senha === confirmar) {
    document.getElementById("mensagem").innerHTML = "";
    document.getElementById("btn_cadastro").disabled = false;
  } else {
    document.getElementById("mensagem").innerHTML = "As senhas não são iguais.";
    document.getElementById("btn_cadastro").disabled = true;
  }
}