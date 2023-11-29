<?php get_header() ?>
<main id="main-content" class="mt-0">
    <div class="fondo">
        <div class="container">
            <div class="title">
                <h1 class="h-2">Resoluciones</h1>
            </div>

            <?php bootstrap_breadcrumb() ?>
            <!-- <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Buscar...', 'placeholder', 'textdomain' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form> -->
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="search-results"></div>

                <?php get_header() ?>
<main id="main-content" class="mt-0">
    <div class="fondo">
        <div class="container">
            <div class="title">
                <h1 class="h-2">Resoluciones</h1>
            </div>

            <?php bootstrap_breadcrumb() ?>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <form class="form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
                        <label class="sr-only" for="search">Buscar</label>
                        <input type="text" class="form-control mr-2" name="s" id="search" value="<?php echo get_search_query(); ?>" placeholder="Buscar...">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
                <div id="search-results"></div>

<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type' => 'resoluciones',
    'orderby' => 'date',
    'order' => 'DESC'
);
$args['posts_per_page'] = 10; // Agregamos esta línea para mostrar solo 10 registros por página
$query = new WP_Query( $args );
?>

<?php if( $query->have_posts() ) : ?>
    <ul class="list-group list-group-flush">
        <?php while( $query->have_posts() ) : $query->the_post(); ?>
            <li class="list-group-item">
                <h2 class="h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="mb-0"><?php the_excerpt(); ?></p>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php
    $big = 999999999;
    $pagination = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $query->max_num_pages
    ) );
    ?>

    <?php if( $pagination ) : ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php echo $pagination; ?>
            </ul>
        </nav>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p>No se encontraron resoluciones.</p>
<?php endif; ?>
<?php get_footer() ?>
<style>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 30px;
  margin-bottom: 10px;
  width: 100%;
}

.pagination .page-item {
  margin: 0 5px;
}

.pagination .page-link {
  border-radius: 20px;
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 0;
  line-height: 30px;
}

.pagination .page-link:hover,
.pagination .page-link:focus {
  z-index: 3;
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.pagination .page-item.active .page-link {
  z-index: 3;
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}


</style>

<?php get_footer(); ?>
