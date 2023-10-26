document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".rating input");
  const submitBtn = document.getElementById("submitBtn");

  submitBtn.addEventListener("click", function () {
    const selectedStar = document.querySelector(".rating input:checked");

    if (selectedStar) {
      const rating = selectedStar.value;
    } else {
      alert("Por favor, selecione uma avaliação.");
    }
  });
});
