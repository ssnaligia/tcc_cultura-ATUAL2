//const senha = document.getElementById('id_senha');
//const confirmar = document.getElementById('id_confirmar');

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

/*tentativa*/
/*function validate(item) {
  item.setCustomValidity('');
  item.checkValidity();

  if (item == confirmar) {
      if(item.value == senha.value) item.setCustomValidity('');
      else item.setCustomValidity('As senhas digitadas não são iguais. Verifique-as e corrija.');
  }
}

senha.addEventListener('input', function () { validate(senha) });
confirmar.addEventListener('input', function () { validate(confirmar) });*/
