function vermais() {
  var pontos = document.getElementById("pontos");
  var maisTexto = document.getElementById("mais");
  var btnVermais = docuemnt.getElementById("btnVermais");

  if (pontos.style.display === "none") {
    pontos.style.display = "inline";
    maisTexto.style.display = "none";
    btnVermais.innerHTML = "Ver mais";
  } else {
    pontos.style.display = "none";
    maisTexto.style.display = "inline";
    btnVermais.innerHTML = "Ver menos";
  }
}
