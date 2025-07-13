document.addEventListener("DOMContentLoaded", function () {
  const titulo = document.getElementById("titulo");
  const texto = titulo.textContent;
  titulo.textContent = ""; // Limpiar el texto original

  let i = 0;
  const velocidad = 75; // milisegundos por letra

  function escribir() {
    if (i < texto.length) {
      titulo.textContent += texto.charAt(i);
      i++;
      setTimeout(escribir, velocidad);
    }
  }

  escribir();
});
