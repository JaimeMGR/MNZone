"use strict";

const alerta = document.querySelector(".alerta");
const contenedor_productos = document.querySelector(".products-container");
const precioapagar = document.querySelector(".total-price");

const carrito = document.querySelector(".cart-overlay");
const cerrar_carrito = document.querySelector(".cart-close");
const carrito_aside = document.querySelector("aside.cart");
const carrito_productos = document.querySelector(".cart-items");
const abrir_carrito = document.querySelector(".toggle-cart");
const vaciarcarrobtn = document.querySelector(".cart-checkout");
const tramitarbtn = document.querySelector(".cart-tramitar");

let preciototal = 0;


document.addEventListener("click", () => {
  carrito.classList.remove("show");

});

carrito_aside.addEventListener("click", (evento) => {
  evento.stopPropagation();
});

abrir_carrito.addEventListener("click", (evento) => {
  evento.stopPropagation();
  carrito.classList.add("show");
});

cerrar_carrito.addEventListener("click", () => {
  carrito.classList.remove("show");
});


const carrito_local = "carrito";
//RENDERIZAR EL LOCALSTORAGE DEL CARRITO

let lista_carrito = JSON.parse(localStorage.getItem(carrito_local)) ?? [];

for (let item of lista_carrito) {
  carrito_productos.appendChild(crearItemCarrito(item));
}

// Recalcular precio total
preciototal = lista_carrito.reduce((total, item) => total + item.precio, 0);
mostrarPrecioTotal(preciototal);


//==================FUNCIONES AUXILIARES=====================================================

function crearItemCarrito(datos_item) {
  const nuevo_item = document.createElement("article");

  nuevo_item.classList.add("cart-item");
  nuevo_item.setAttribute("id_producto", datos_item.id_producto);
  preciototal = preciototal + datos_item.precio;
  nuevo_item.innerHTML = `
  <img src="${datos_item.imagen}"
            class="cart-item-img"
            alt="${datos_item.nombre_producto}"
          />  
          <div>
            <h4 class="cart-item-name">${datos_item.nombre_producto}</h4>
            <p class="cart-item-price">${datos_item.precio + " €"}</p>
            <button class="cart-item-remove-btn" data-id_producto="${datos_item.id_producto}">Eliminar <i class="fas fa-times"></i></button>
          </div>`;
  mostrarPrecioTotal(preciototal);
  //BOTON DE ELIMINAR 
  let boton_eliminar = nuevo_item.querySelector(".cart-item-remove-btn");
  boton_eliminar.addEventListener("click",
    () => {
      preciototal = preciototal - datos_item.precio;
      mostrarPrecioTotal(preciototal);
      let posicion = lista_carrito.findIndex(item => item["id_producto"] === datos_item["id_producto"]);
      lista_carrito.splice(posicion, 1);

      // Guarda en el localstorage
      localStorage.setItem(carrito_local, JSON.stringify(lista_carrito));

      nuevo_item.remove();

      mostrarMensaje("Producto eliminado del carrito", "danger");
    }
  );
  return nuevo_item;



}


vaciarcarrobtn.addEventListener("click", () => {
  lista_carrito = [];
  // Ahora se vacía el contenido del carrito_productos
  carrito_productos.innerHTML = "";

  // y se reinicia el precio total
  preciototal = 0;
  mostrarPrecioTotal(preciototal);

  mostrarMensaje("Se ha vaciado el carrito", "success");
});

const añadir_carrito = document.querySelectorAll(".product-cart-btn");
for (let carrito_boton of añadir_carrito) {
  //EVENTO CLICK DEL BOTON AÑADIR AL CARRITO DE CADA PRODUCTO
  carrito_boton.addEventListener("click",
    () => {
      let id_producto = carrito_boton.parentNode.parentNode.getAttribute("data-id");
      let seleccionado = lista[id_producto];

      let nuevo_item = crearItemCarrito(seleccionado);
      carrito_productos.appendChild(nuevo_item);

      lista_carrito.push(seleccionado);

      localStorage.setItem(carrito_local, JSON.stringify(lista_carrito));


      mostrarMensaje("Producto añadido al carrito", "success");
    }
  )
}

function mostrarPrecioTotal($preciototal) {
  // la variable preciototal solo puede llegar a tener 2 decimales
  $preciototal = parseFloat($preciototal.toFixed(2));
  precioapagar.innerHTML = `<h3>${$preciototal + " €"}</h3>`;
}

function mostrarMensaje(texto, clase) {
  alerta.innerHTML = `<h3 style="text-transform: none;">${texto}</h3>`;

  alerta.classList.add(clase);
  // remove alert
  setTimeout(() => {
    alerta.innerText = "";
    alerta.classList.remove(clase);
  }, 1000);
}

// Si se cierra sesión se debe de eliminar el localstorage

// window.addEventListener("beforeunload", () => {
//   localStorage.clear()
// });

// var slider = document.getElementById("precio");
// var output = document.getElementById("demo");
// output.innerHTML = slider.value;

// slider.oninput = function () {
//   output.innerHTML = this.value;
// }

// Utilizando el botón const tramitarbtn = document.querySelector(".cart-tramitar"); necesito tramitar el pedido llevándote a un formulario para realizar el pago llevando con si todos los productos del carrito y el precio total.
// Botón para tramitar el pedido
tramitarbtn.addEventListener("click", () => {
  if (lista_carrito.length === 0) {
    mostrarMensaje("El carrito está vacío", "danger");
    return;
  }
  // Redirigir a la página de pago
  const url = new URL("pago.php", window.location.href);
  url.searchParams.set("productos", JSON.stringify(lista_carrito));
  url.searchParams.set("total", preciototal);
  window.location.href = url.toString();
});