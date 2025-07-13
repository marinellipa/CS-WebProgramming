let indice = 0;
const fondo = document.querySelector('.carrusel-fondo');
const titulo = document.getElementById('actividad-titulo');
const link = document.getElementById('actividad-link');
const modalidad = document.getElementById('actividad-modalidad');
const pistas = document.getElementById('actividad-pistas');

function mostrarActividad(i) {
    if (window.actividades.length === 0) return;
    fondo.style.backgroundImage = `url('${window.actividades[i].imagen}')`;
    titulo.textContent = window.actividades[i].nombre;
    modalidad.textContent = "Modalidad: " + window.actividades[i].modalidad;
    pistas.textContent = "Nº de pistas: " + window.actividades[i].pistas;
    link.href = "actividad.php?id=" + window.actividades[i].id;
}

document.getElementById('flecha-izq').onclick = function() {
    indice = (indice - 1 + window.actividades.length) % window.actividades.length;
    mostrarActividad(indice);
};
document.getElementById('flecha-der').onclick = function() {
    indice = (indice + 1) % window.actividades.length;
    mostrarActividad(indice);
};

mostrarActividad(indice);