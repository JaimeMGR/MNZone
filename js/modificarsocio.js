"use strict"

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        // Variables de los campos del formulario
        const nombre = document.getElementById("nombre").value.trim();
        const edad = parseInt(document.getElementById("edad").value.trim());
        const usuario = document.getElementById("usuario").value.trim();
        const telefono = document.getElementById("telefono").value.trim();
        const imagen = document.getElementById("imagen").files[0];

        // Validaciones
        // Nombre: solo letras, 4-50 caracteres
        if (!/^[a-zA-Z\s]{4,50}$/.test(nombre)) {
            alert("El nombre debe contener solo letras, entre 4 y 50 caracteres.");
            event.preventDefault();
            return;
        }

        // Edad: al menos 18 años
        if (isNaN(edad) || edad < 18) {
            alert("La edad debe ser un número mayor o igual a 18.");
            event.preventDefault();
            return;
        }

        // Edad: menos de 101 años
        if (isNaN(edad) || edad > 101) {
            alert("Vete a ver Juan y Medio.");
            event.preventDefault();
            return;
        }

        // Usuario: letras, números, empieza con letra, 5-20 caracteres
        if (!/^[a-zA-Z][a-zA-Z0-9]{4,19}$/.test(usuario)) {
            alert("El usuario debe comenzar con una letra, tener entre 5 y 20 caracteres, y contener solo letras o números.");
            event.preventDefault();
            return;
        }

        // Teléfono: formato español (+34 seguido de 9 dígitos)
        if (telefono && !/^\+34\d{9}$/.test(telefono)) {
            alert("El teléfono debe tener el formato español (+34 seguido de 9 dígitos).");
            event.preventDefault();
            return;
        }

        // Imagen: formato JPEG y tamaño máximo de 5MB
        if (imagen) {
            if (imagen.type !== "image/jpeg") {
                alert("La imagen debe ser un archivo JPEG.");
                event.preventDefault();
                return;
            }
            if (imagen.size > 5 * 1024 * 1024) {
                alert("La imagen no debe superar los 5MB de tamaño.");
                event.preventDefault();
                return;
            }
        }
    });
});