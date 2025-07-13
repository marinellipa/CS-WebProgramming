document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-altausuario').onsubmit = function(e) {
        let errores = [];
        let nombre = document.getElementById('nombre').value.trim();
        let apellido = document.getElementById('apellido').value.trim();
        let email = document.getElementById('email').value.trim();
        let telefono = document.getElementById('telefono').value.trim();
        let fecha = document.getElementById('fecha_nacimiento').value.trim();
        let username = document.getElementById('username-reg').value.trim();
        let password = document.getElementById('password-reg').value;
        let confirm_password = document.getElementById('confirm_password-reg').value;

        // Validaciones
        if (!nombre) errores.push("El nombre es obligatorio.");
        if (!apellido) errores.push("El apellido es obligatorio.");
        if (!email) {
            errores.push("El correo electrónico es obligatorio.");
        } else if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
            errores.push("El correo electrónico no es válido. Debe tener formato usuario@dominio.com");
        }
        if (!telefono) {
            errores.push("El teléfono es obligatorio.");
        } else if (!/^\d{9}$/.test(telefono)) {
            errores.push("El teléfono debe tener 9 dígitos numéricos.");
        }
        if (fecha && !/^\d{4}-\d{2}-\d{2}$/.test(fecha)) {
            errores.push("La fecha de nacimiento debe tener formato YYYY-MM-DD.");
        }
        if (!username) errores.push("El nombre de usuario es obligatorio.");
        if (!password) errores.push("La contraseña es obligatoria.");
        if (!confirm_password) errores.push("Debes confirmar la contraseña.");
        if (password && confirm_password && password !== confirm_password) {
            errores.push("Las contraseñas no coinciden.");
        }

        // Mostrar errores o enviar
        if (errores.length > 0) {
            e.preventDefault();
            document.getElementById('errores').innerHTML =
                '<ul>' + errores.map(e => `<li>${e}</li>`).join('') + '</ul>';
        }
    };
});