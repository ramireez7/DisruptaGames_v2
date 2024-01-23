"use strict";

(() => {
  window.addEventListener("load", () => {
    let enlacesDelete = document.querySelectorAll(".delete");
    enlacesDelete.forEach((enlace) => {
      enlace.addEventListener("click", function (event) {
        event.preventDefault();
        let url = this.href;
        let enlaceActual = this;
        fetch(url, { method: "DELETE" })
          .then((response) => response.json())
          .then((data) => {
            if (data.eliminado === true) {
              enlaceActual.parentNode.parentNode.remove();
              alert("Imagen borrada correctamente!");
            }
          });
        return false;
      });
    });
  });
})();