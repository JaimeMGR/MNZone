const abrirmenu = document.getElementById("abrirmenu");
const cerrarmenu = document.getElementById("Cerrarmenu");
const menuNav = document.getElementById("menuNav");
const cerrar_sesion = document.getElementById("login-form");

//Abrir menu
abrirmenu.addEventListener("click", function () {
    abrirmenu.classList.add("collapse");
});

//Cerrar menu
cerrarmenu.addEventListener("click", function () {
    menuNav.classList.remove("show");
    //   también tienes que quitarle el hidden al botón de abrir el menu
    abrirmenu.classList.remove("hidden");
    abrirmenu.classList.remove("collapse");
});