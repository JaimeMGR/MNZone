"use strict"

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        // Variables de los campos del formulario
        const titulo = document.getElementById("titulo").value.trim();
        const contenido = document.getElementById("contenido").value.trim();
        const imagen = document.getElementById("imagen").files[0];

        // Obtener la fecha actual
        const fechaActual = new Date();
        const fechaPublicacion = new Date(document.getElementById("fecha_publicacion")?.value);

        // Validaciones
        // Validar título: mínimo 3 caracteres
        if (titulo.length < 3) {
            alert("El título debe tener al menos 3 caracteres.");
            event.preventDefault();
            return;
        }

        // Validar contenido: mínimo 3 caracteres
        if (contenido.length < 3) {
            alert("El contenido debe tener al menos 3 caracteres.");
            event.preventDefault();
            return;
        }

        // Validar fecha de publicación: posterior a la fecha actual
        if (isNaN(fechaPublicacion) || fechaPublicacion <= fechaActual) {
            alert("La fecha de publicación debe ser posterior a la fecha actual.");
            event.preventDefault();
            return;
        }

        // Validar imagen: formato JPEG y tamaño máximo de 5MB
        if (imagen) {
            if (imagen.type !== "image/jpeg") {
                alert("La imagen debe estar en formato JPEG.");
                event.preventDefault();
                return;
            }
            if (imagen.size > 5 * 1024 * 1024) { // 5MB
                alert("La imagen no debe superar los 5MB de tamaño.");
                event.preventDefault();
                return;
            }
        } else {
            alert("Es obligatorio subir una imagen en formato JPEG.");
            event.preventDefault();
            return;
        }
    });
});