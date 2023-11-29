<?php

/*

Template Name: Viviendas Económicas Archive

*/



get_header();

?>



<div class="fondo">

    <div class="container">

        <div class="title">

            <h1 class="h-2">Viviendas Económicas</h1>

        </div>

        <?php bootstrap_breadcrumb() ?>

    </div>

</div>



<div id="primary" class="content-area">

    <main id="main" class="site-main">

        <div class="container">

            <div class="row">



                <?php

                $args = array(

                    'post_type'      => 'viviendaseconomicas',

                    'posts_per_page' => -1,

                );



                $query = new WP_Query($args);



                if ($query->have_posts()) {

                    while ($query->have_posts()) {

                        $query->the_post();

                        $estado_convocatoria = get_post_meta(get_the_ID(), 'estado_convocatoria', true);

                        $convocatoria_link = get_post_meta(get_the_ID(), 'convocatoria', true);

                        $informaciones_link = get_post_meta(get_the_ID(), 'informaciones', true);

                        $requisitos_link = get_post_meta(get_the_ID(), 'requisitos', true);

                        $adjudicados_link = get_post_meta(get_the_ID(), 'adjudicados', true);

                        $descalificados_link = get_post_meta(get_the_ID(), 'descalificados', true);



                        if ($convocatoria_link) :

                ?>

                            <div class="col-md-4">

                                <article id="post-<?php the_ID(); ?>" <?php post_class('card mb-4'); ?>>

                                    <header class="">

                                        <h2 class="card-title cintillos"><?php echo get_the_title(); ?> - <?php echo esc_html($estado_convocatoria); ?></h2>

                                    </header>



                                    <div class="card-body">

                                        <?php the_post_thumbnail('medium', array('class' => 'img-fluid rounded mb-3 imagen-destacada')); ?>



                                        <?php

                                        $botones = array();

                                        if ($informaciones_link) {

                                            $botones[] = '<a href="' . esc_url($informaciones_link) . '" class="btn btn-primary btn-sm">Ver Informaciones</a>';

                                        }

                                        if ($requisitos_link) {

                                            $botones[] = '<a href="' . esc_url($requisitos_link) . '" class="btn btn-primary btn-sm">Ver Requisitos</a>';

                                        }

                                        if ($adjudicados_link) {

                                            $botones[] = '<a href="' . esc_url($adjudicados_link) . '" class="btn btn-primary btn-sm">Ver Adjudicados</a>';

                                        }

                                        if ($descalificados_link) {

                                            $botones[] = '<a href="' . esc_url($descalificados_link) . '" class="btn btn-primary btn-sm">Ver Descalificados</a>';

                                        }



                                        // Mostrar los botones solo si hay al menos uno

                                        if (!empty($botones)) {

                                            echo implode(' ', $botones);

                                        }

                                        ?>

                                    </div>

                                </article>

                            </div>

                <?php

                        endif;

                    }



                    // Array de títulos

                    $titulos_informaciones = array(

                        'VIVIENDAS ECONOMICAS',

                        'A QUÉ PÚBLICO ESTÁ DIRIGIDO',

                        'EN EL CASO DE GRUPOS FAMILIARES

                        ',

                        'CÓMO ACCEDER

                        ',

                        'VIVIENDAS ENTREGADAS

                        ',

                        'PROYECTO LOCALIDAD DEPARTAMENTO CANTIDAD DE VIVIENDAS

                        ',

                        'INCLUSIÓN SOCIAL

                        ',

                        'CONTACTOS',

                    );



                    // Mostrar secciones "titulo_informaciones_2" hasta "titulo_informaciones_9" con clase "cintillos"

                    for ($i = 2; $i <= 9; $i++) {

                        while ($query->have_posts()) {

                            $query->the_post();

                            $informaciones_link = get_post_meta(get_the_ID(), 'informaciones', true);



                            if ($informaciones_link) :

                                $informaciones_content = get_post_meta(get_the_ID(), 'titulo_informaciones_' . $i, true);



                                if ($informaciones_content) :

                ?>

                                    <div class="col-md-12">

                                        <div class="card mb-4">

                                            <div class="card-body">

                                                <h3 class="cintillos"><?php echo $titulos_informaciones[$i - 2]; ?></h3>

                                                <?php echo apply_filters('the_content', $informaciones_content); ?>

                                            </div>

                                        </div>

                                    </div>

                <?php

                                endif;

                            endif;

                        }

                    }

                } else {

                    echo '<p>No se encontraron viviendas económicas</p>';

                }



                wp_reset_postdata(); // Restaurar datos originales del post global

                ?>



            </div>

        </div>

    </main>

</div>



<?php

get_footer();

?>

