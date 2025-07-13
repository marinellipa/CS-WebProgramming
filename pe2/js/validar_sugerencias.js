document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-sugerencias').onsubmit = function(e) {
        let errores = [];
        let nombre = document.getElementById('nombre').value.trim();
        let email = document.getElementById('email').value.trim();
        let sugerencia = document.getElementById('sugerencia').value.trim();

        if (!nombre) {
            errores.push("El nombre es obligatorio.");
        }
        if (!email) {
            errores.push("El correo electrónico es obligatorio.");
        } else if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
            errores.push("El correo electrónico no es válido. Debe tener formato usuario@dominio.com");
        }
        if (!sugerencia) {
            errores.push("La sugerencia no puede estar vacía.");
        }

        if (errores.length > 0) {
            e.preventDefault();
            document.getElementById('errores').innerHTML =
                '<ul>' + errores.map(e => `<li>${e}</li>`).join('') + '</ul>';
        }
    };
});