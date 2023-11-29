// Obtener el contenido del popup desde WordPress
fetch('<?php echo get_permalink(ID_DEL_POPUP); ?>')
  .then(response => response.text())
  .then(data => {
    // Agregar el contenido al HTML del popup muvh
    var popupMuvhContenido = document.querySelector('.popup-muvh-contenido');
    popupMuvhContenido.innerHTML = data;
  })
  .catch(error => console.log(error));