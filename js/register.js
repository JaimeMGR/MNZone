document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const nombre = document.getElementById("nombre");
    const usuario = document.getElementById("usuario");
    const edad = document.getElementById("edad");
    const contrasena = document.getElementById("contrasena");
    const telefono = document.getElementById("telefono");
    const foto = document.getElementById("foto");
    const boton = document.querySelector("button");

    const regexNombre = /^[a-zA-Z\s]{4,50}$/;
    const regexUsuario = /^[a-zA-Z][a-zA-Z0-9]{4,19}$/;
    const regexContrasena = /^[a-zA-Z][a-zA-Z0-9_]{7,15}$/;
    const regexTelefono = /^\+34\d{9}$/;

    function validarCampo(input, regex, mensaje) {
        const error = input.nextElementSibling;
        if (!regex.test(input.value.trim())) {
            error.textContent = mensaje;
            return false;
        } else {
            error.textContent = "";
            return true;
        }
    }

    function validarEdad() {
        const error = edad.nextElementSibling;
        const valor = parseInt(edad.value, 10);
        if (isNaN(valor) || valor < 18) {
            error.textContent = "Debes tener al menos 18 años.";
            return false;
        } else if (valor > 100) {
            error.textContent = "Vete a ver Juan y Medio.";
            return false;
        } else {
            error.textContent = "";
            return true;
        }
    }

    function validarFoto() {
        const error = foto.nextElementSibling;
        if (!foto.files.length) {
            error.textContent = "Es obligatorio subir una foto.";
            return false;
        }
        const archivo = foto.files[0];
        if (archivo.type !== "image/jpeg") {
            error.textContent = "La foto debe ser un archivo JPEG.";
            return false;
        }
        if (archivo.size > 5 * 1024 * 1024) {
            error.textContent = "La foto no debe superar los 5MB.";
            return false;
        }
        error.textContent = "";
        return true;
    }

    function validarFormulario() {
        const nombreValido = validarCampo(nombre, regexNombre, "El nombre debe contener solo letras, entre 4 y 50 caracteres.");
        const usuarioValido = validarCampo(usuario, regexUsuario, "El usuario debe empezar con letra y tener entre 5 y 20 caracteres.");
        const edadValida = validarEdad();
        const contrasenaValida = validarCampo(contrasena, regexContrasena, "La contraseña debe empezar con una letra, contener solo letras, números o '_', y tener entre 8 y 16 caracteres.");
        const telefonoValido = validarCampo(telefono, regexTelefono, "El teléfono debe tener formato +34 seguido de 9 dígitos.");
        const fotoValida = validarFoto();

        boton.disabled = !(nombreValido && usuarioValido && edadValida && contrasenaValida && telefonoValido && fotoValida);
    }

    [nombre, usuario, edad, contrasena, telefono].forEach(input => {
        input.insertAdjacentHTML("afterend", "<p class='error' style='color:red; font-size: 14px;'></p>");
        input.addEventListener("input", validarFormulario);
    });

    foto.insertAdjacentHTML("afterend", "<p class='error' style='color:red; font-size: 14px;'></p>");
    foto.addEventListener("change", validarFormulario);

    validarFormulario(); // Para deshabilitar el botón al inicio
});
