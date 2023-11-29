<?php
/**
 * Template Name: Biblioteca Digital Page
 */

get_header();
?>

<main id="main-content" class="mt-0">
    <div class="fondo">
        <div class="container">
            <div class="title">
                <h1 class="h-2">Biblioteca Digital</h1>
            </div>
            <?php // bootstrap_breadcrumb() ?>
        </div>
    </div>

    <div class="container mt-4">
        <?php
        $terms = get_terms(array(
            'taxonomy' => 'categoria-biblioteca',
            'hide_empty' => false,
        ));

        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $args = array(
                    'post_type' => 'biblioteca-digital',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categoria-biblioteca',
                            'field' => 'slug',
                            'terms' => $term->slug,
                            'order'=> 'DESC',

                        ),
                    ),
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) :
        ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="titulo">
                                <span class="cintillo-titulos"><?php echo $term->name; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        while ($query->have_posts()) : $query->the_post();
                            $enlace = get_post_meta(get_the_ID(), 'enlace', true);
                        ?>

                            <div class="col-md-3 mb-4">
                                <div class="card position-relative d-flex" style="height: 320px;">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php the_post_thumbnail_url(); ?>" class="card-img-top img-fluid rounded" style="height: 60%; object-fit: cover;" alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                    <div class="cintillo-titulos position-absolute w-100" style="top: 60%; background-color: rgba(0, 0, 0, 0.7); padding: 12px 20px 10px 15px; z-index: 1;">
                                        <h5 class="card-title"><?php the_title(); ?></h5>
                                    </div>
                                    <div class="card-body" style="position: absolute; bottom: 0; left: 0; right: 0; padding: 10px;">
                                        <a href="<?php echo esc_url($enlace); ?>" class="btn btn-default btn-sm stretched-link" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); z-index: 2;">Ver</a>
                                    </div>
                                </div>
                            </div>

                        <?php
                        endwhile;
                        ?>
                    </div>
        <?php
                    wp_reset_postdata();
                endif;
            }
        }
        ?>
    </div>
</main>

<style>

    h5 {    font-family: 'Montserrat'; color:#fff;     font-size: 12px;
}
    .titulo {
        margin-bottom: 20px;
        border-bottom: 2px solid #EA2428 !important;
        padding-bottom: 10px;
    }

    .cintillo-titulos {
    font-weight: bold;
    background-color: #EA2428 !important;
    padding: 13px;
    text-transform: uppercase;
    font-size: 12px;
    font-family: 'Montserrat';
    color: #FFF;
    transition: transform 0.3s ease-in-out; /* Agrega la transición */

}

.cintillo-titulos:hover {
    transform: translateY(-5px); /* Agrega el desplazamiento vertical al pasar el mouse */
}
</style>

<?php
get_footer();
?>