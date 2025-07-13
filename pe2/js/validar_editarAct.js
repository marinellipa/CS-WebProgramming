document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-editar-actividad');
    form.onsubmit = function(e) {
        let errores = [];

        let nombre = form.nombre.value.trim();
        let categoria = form.categoria.value.trim();
        let modalidad = form.modalidad.value.trim();
        let pistas = form.pistas.value.trim();
        let descripcion = form.descripcion.value.trim();
        let imagen = form.imagen.value.trim();

        if (!nombre) errores.push("El nombre es obligatorio.");
        if (!categoria) errores.push("La categoría es obligatoria.");
        if (!modalidad) errores.push("La modalidad es obligatoria.");
        if (!pistas) {
            errores.push("El número de pistas es obligatorio.");
        } else if (isNaN(pistas) || parseInt(pistas) <= 0) {
            errores.push("El número de pistas debe ser un número mayor que 0.");
        }
        if (!descripcion) errores.push("La descripción es obligatoria.");
        if (!imagen) errores.push("Debes seleccionar una imagen.");

        const erroresSection = document.getElementById('errores');
        if (errores.length > 0) {
            e.preventDefault();
            erroresSection.innerHTML = '<ul>' + errores.map(e => `<li>${e}</li>`).join('') + '</ul>';
        } else {
            erroresSection.innerHTML = '';
        }
    };
});