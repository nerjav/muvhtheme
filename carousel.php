<?php
// Obtener los últimos 5 posts
$posts = get_posts(array('numberposts' => 5));

// Verificar si hay posts
if ($posts) {
    echo '<div id="post-slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">';

    // Iterar sobre cada post
    foreach ($posts as $key => $post) {
        setup_postdata($post);

        // Agregar la clase "active" al primer elemento del slider
        $active_class = ($key === 0) ? 'active' : '';

        // Obtener la URL de la imagen destacada
        $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'large');

        echo '<div class="carousel-item ' . $active_class . '">
                <div class="image-overlay" style="position: relative;"> <!-- Agregar contenedor con clase image-overlay -->
                    <img src="' . esc_url($thumbnail_url) . '" class="d-block w-100" alt="' . '">
                    <div class="cab_per p-3" style="position: absolute; bottom: 0; left: 0; width: 100%;">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                <img src="http://192.168.99.159/demo/wp-content/uploads/2023/11/Programas-Habitacionales.png" alt="Imagen en columna 1" class="img-fluid logopro " style="
                                width: 197px;
                            ">                                </div>
                                <div class="col-md-6 text-white">
                                    Columna 2
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-caption d-none d-md-block">
              
                </div>
              </div>';
    }

    echo '</div>
          <a class="carousel-control-prev" href="#post-slider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#post-slider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>';
}

// Restaurar la configuración global de post
wp_reset_postdata();
?>

<!-- Agregar el estilo CSS para la superposición -->
<style>
.image-overlay {
    position: relative;
}

.logopro {width:280px; }

.image-overlay img {
    width: 100%;
    height: auto;
}

.cab_per{background:#EA2428;}

</style>

<script>
jQuery(document).ready(function($) {
    // Iniciar el slider y habilitar el desplazamiento automático
    $("#post-slider").carousel({
        interval: 5000 // 5000 milisegundos (5 segundos)
    });
});
</script>
