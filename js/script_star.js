document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".rating input");
  const submitBtn = document.getElementById("submitBtn");

  submitBtn.addEventListener("click", function () {
    const selectedStar = document.querySelector(".rating input:checked");

    if (selectedStar) {
      const rating = selectedStar.value;

      // Enviar a avaliação para o backend (usando AJAX ou Fetch)
      // Aqui você deve fazer uma requisição para o script PHP no backend
    } else {
      alert("Por favor, selecione uma avaliação.");
    }
  });
});
