document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-inscripcion').onsubmit = function(e) {
        let errores = [];
        let evento = document.getElementById('evento').value.trim();
        let grupo = document.getElementById('grupo').value.trim();
        let edad = document.getElementById('edad').value.trim();
        let nombre = document.getElementById('nombre').value.trim();
        let email = document.getElementById('email').value.trim();
        let primeraVez = document.querySelector('input[name="primera_vez"]:checked');
        
        // Validación de evento
        if (!evento) {
            errores.push("Debes seleccionar un evento.");
        }
        // Validación de grupo
        if (!grupo) {
            errores.push("El nombre del equipo es obligatorio.");
        }
        // Validación de primera vez
        if (!primeraVez) {
            errores.push("Debes indicar si es la primera vez que participas.");
        }
        // Validación de edad
        if (!edad) {
            errores.push("La edad es obligatoria.");
        } else if (isNaN(edad) || parseInt(edad) < 1) {
            errores.push("La edad debe ser un número mayor que 0.");
        }
        // Validación de nombre
        if (!nombre) {
            errores.push("El nombre es obligatorio.");
        }
        // Validación de email
        if (!email) {
            errores.push("El correo electrónico es obligatorio.");
        } else if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
            errores.push("El correo electrónico no es válido. Debe tener formato usuario@dominio.com");
        }

        // Mostrar errores o enviar
        if (errores.length > 0) {
            e.preventDefault();
            document.getElementById('errores').innerHTML =
                '<ul>' + errores.map(e => `<li>${e}</li>`).join('') + '</ul>';
        }
    };
});