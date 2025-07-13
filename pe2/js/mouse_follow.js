document.addEventListener("DOMContentLoaded", function () {
  const cursor = document.createElement("div");
  cursor.id = "custom-cursor";
  document.body.appendChild(cursor);

  const style = document.createElement("style");
  style.textContent = `
    #custom-cursor {
      position: fixed;
      top: 0;
      left: 0;
      width: 32px;
      height: 32px;
      background-image: url('imagenes/pelota.png');
      background-size: cover;
      background-repeat: no-repeat;
      border-radius: 50%;
      pointer-events: none;
      transform: translate(-50%, -50%);
      transition: transform 0.05s ease;
      z-index: 9999;
    }
  `;
  document.head.appendChild(style);

  document.addEventListener("mousemove", (e) => {
    cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
  });
});
