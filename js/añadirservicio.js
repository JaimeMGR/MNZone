"use strict"

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        // Variables de los campos del formulario
        const nombre = document.getElementById("nombre").value.trim();
        const duracion = parseInt(document.getElementById("duracion").value.trim());
        const foto = document.getElementById("foto").files[0];

        // Validaciones
        // Nombre: longitud entre 3 y 50 caracteres
        if (nombre.length < 3 || nombre.length > 50) {
            alert("El nombre del servicio debe tener entre 3 y 50 caracteres.");
            event.preventDefault();
            return;
        }

        // Duración: mínimo 15 minutos
        if (isNaN(duracion) || duracion < 15) {
            alert("La duración debe ser como mínimo 15 minutos.");
            event.preventDefault();
            return;
        }

        // El precio no puede ser inferior a 0
        const precio = parseFloat(document.getElementById("precio").value.trim());
        if (isNaN(precio) || precio < 0) {
            alert("El precio del servicio debe ser un número positivo.");
            event.preventDefault();
            return;
        }

        // Foto: formato imagen (JPEG/PNG/etc.) y tamaño máximo de 5MB
        if (foto) {
            if (!["image/jpeg", "image/png", "image/gif"].includes(foto.type)) {
                alert("La imagen debe ser de formato JPEG, PNG o GIF.");
                event.preventDefault();
                return;
            }
            if (foto.size > 5 * 1024 * 1024) { // 5MB
                alert("La imagen no debe superar los 5MB de tamaño.");
                event.preventDefault();
                return;
            }
        } else {
            alert("Es obligatorio subir una imagen.");
            event.preventDefault();
            return;
        }
    });
});