<?php get_header() ?>

<style>
.mi-vivienda-h3 {
  color: #001C54;
  font-family: "Roboto", Sans-serif;
  font-size: 18px;
  font-weight: 600;
}


.tipo-contenido {
  background-color: #003cb2;
  color: #fff;
  padding: 10px 0;
  text-align: center;
  margin-bottom: 20px;
}


.titulo-doc {
    display: block;
    background-color: #002455;
    color: #FFF;
    font-family: 'Montserrat';
    font-size: 12px;
    padding: 12px 20px 10px 15px;
    text-transform: uppercase;
    margin-top: 15px;
    text-align: center;
    font-weight: bold;
    background-image: url(https://www.muvh.gov.py/sitio/wp-content/uploads/2018/11/gov.png);
    background-size: 12px !important;
    background-position: center right !important;
    background-repeat: no-repeat !important;
    width: 530px;
}

</style>

  <main id="main-content" class="mt-0">
                                <div class="fondo">
                                    <div class="container">
                                        <div class="title">
                                            <h1 class="h-2">Mi Vivienda</h1>
                                        </div>
                        
                                        <?php bootstrap_breadcrumb() ?>
                                    </div>
                                </div>
                                <div class="container mb-4">
                                    <section id="content">  
<div class="container">
  <div class="row">

    <?php
    $args = array(
      'post_type' => 'mi_vivienda',
      'posts_per_page' => 8,
      'order' => 'ASC',
      'orderby' => 'date'
    );
    $query = new WP_Query($args);
    if ($query->have_posts()):
      while ($query->have_posts()): $query->the_post();
        $tipoContenido = get_field('tipo_contenido');
    ?>


        <?php if ($tipoContenido !== 'video'): ?>

          <div class="col-md-6">
        <?php else: ?>

          <div class="col-md-12 d-flex justify-content-center">

        <?php endif; ?>

        <div class="d-flex flex-column align-items-center text-center"> <!-- Agregada la clase "text-center" -->
          
          <?php if ($tipoContenido !== 'video'): ?>
            <h3 class="titulo-doc"><?php the_title(); ?></h3>
          <?php endif; ?>

          <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('large', array('class' => 'img-fluid', 'alt' => get_the_title())); ?>
          <?php endif; ?>

          <?php
          $botones = get_field('botones');
          $tieneBoton = !empty($botones);

          $recursos = get_field('recursos');
          $tieneRecursos = !empty($recursos);

          $recursos2 = get_field('recursos2');
          $tieneRecursos2 = !empty($recursos2);

          $recursos3 = get_field('recursos3');
          $tieneRecursos3 = !empty($recursos3);

          $requisitos = get_field('requisitos');
          $tieneRequisitos = !empty($requisitos);

          $formulario2 = get_field('formulario2');
          $tieneFormulario2 = !empty($formulario2);

          $tieneTituloExtra = ($tieneBoton && !$tieneRecursos && !$tieneRecursos2 && !$tieneRecursos3 && !$tieneRequisitos && !$tieneFormulario2);
          ?>

          <?php if ($tieneBoton || $tieneRecursos || $tieneRecursos2 || $tieneRecursos3 || $tieneRequisitos || $tieneFormulario2): ?>
            <h4 class="titulo-doc">Documentación Requerida</h4>
          <?php endif; ?>

          <?php
          if (!empty($botones)):
            foreach ($botones as $boton):
              $url = $boton['url'];
              $titulo = $boton['recursos'];
              $titulo2 = $boton['recursos2'];
              $titulo3 = $boton['recursos3'];
          ?>
              <?php if ($titulo): ?>
                <a href="<?php echo $url; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> <?php echo $titulo; ?></a>
              <?php endif; ?>

              <?php if ($titulo2): ?>
                <a href="<?php echo $url; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> <?php echo $titulo2; ?></a>
              <?php endif; ?>

              <?php if ($titulo3): ?>
                <a href="<?php echo $url; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> <?php echo $titulo3; ?></a>
              <?php endif; ?>

          <?php
            endforeach;
          endif;
          ?>

          <?php if ($tieneRecursos): ?>
            <a href="<?php echo $recursos; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> Descargar formularios</a>
          <?php endif; ?>

          <?php if ($tieneRecursos2): ?>
            <a href="<?php echo $recursos2; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> Descargar bases y condiciones</a>
          <?php endif; ?>

          <?php if ($tieneRecursos3): ?>
            <a href="<?php echo $recursos3; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> Descargar documentos requeridos</a>
          <?php endif; ?>

          <?php if ($tieneRequisitos): ?>
            <a href="<?php echo $requisitos; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> Descargar Requisitos</a>
          <?php endif; ?>

          <?php if ($tieneFormulario2): ?>
            <a href="<?php echo $formulario2; ?>" class="btn btn-primary mb-2"><i class="fas fa-download"></i> Descargar Formulario </a>
          <?php endif; ?>

          <?php if (is_user_logged_in()): ?>
            <a href="<?php echo get_edit_post_link(); ?>" class=""><i class="fas fa-pencil-alt"></i> Editar</a>
          <?php endif; ?>
          <?php if ($tipoContenido === 'video'): ?>
            <?php the_content(); ?>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>         </main>
                      
                    
                     <?php include('footer.php'); ?>