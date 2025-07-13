document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-actividad').onsubmit = function(e) {
        let errores = [];
        let nombre = this.nombre.value.trim();
        let categoria = this.categoria.value.trim();
        let modalidad = this.modalidad.value.trim();
        let pistas = this.pistas.value.trim();
        let imagen = this.imagen.value.trim();
        let descripcion = this.descripcion.value.trim();

        if (!nombre) errores.push("El nombre de la actividad es obligatorio.");
        if (!categoria) errores.push("Debes seleccionar una categoría.");
        if (!modalidad) errores.push("Debes seleccionar una modalidad.");
        if (!pistas) {
            errores.push("El número de pistas es obligatorio.");
        } else if (isNaN(pistas) || parseInt(pistas) < 1) {
            errores.push("El número de pistas debe ser un número mayor que 0.");
        }
        if (!descripcion) {
            errores.push("La descripción es obligatoria.");
        }
        if (!imagen) errores.push("Debes seleccionar una imagen.");

        if (errores.length > 0) {
            e.preventDefault();
            document.getElementById('errores').innerHTML =
                '<ul>' + errores.map(e => `<li>${e}</li>`).join('') + '</ul>';
        }
    };
});