"use strict"

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        // Variables de los campos del formulario
        const contenido = document.getElementById("contenido").value.trim();
        const socio = document.getElementById("socio").value;

        // Validaciones
        // Validar que el contenido del testimonio no esté vacío
        if (contenido === "") {
            alert("El contenido del testimonio no puede estar vacío.");
            event.preventDefault();
            return;
        }

        // Validar que se haya seleccionado un socio
        if (socio === "") {
            alert("Debe seleccionar un socio.");
            event.preventDefault();
            return;
        }
    });
});