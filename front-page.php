<?php get_header() ?>
<?php include('carousel.php'); ?>


<main id="main-content" class="mt-1">
    <div class="d-none d-sm-block  d-sm-none d-md-block">
        <div class="container d-none d-sm-block  d-sm-none d-md-block">



        </div>
    </div>
   
</div> 


    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="bloques">
                            <?php get_sidebar(); ?>
                        </div>

                    </div>

                    <div class="col-sm-8">
                        <div class="bloque1">
                            <h6 class="pt-3 pb-1">Últimas noticias publicadas</h6>
                            <?php

include('plantilla_noticias.php');
$args = null;
wp_reset_query(); 
?>
                         


                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-3 contentsidebar">
                <div class="bloques">
                     <h3>Buscar en el sitio</h3>
                    <form id="header-search" action="<?php echo esc_url(home_url('/')); ?>" method="GET">
                        <input type="text" name="s" id="search-input" value="<?php the_search_query(); ?>"
                            class="form-control">
                        <input name="submit" type="submit" value="buscar" class="btn btn-outline-secondary buscar">
                    </form> 
                </div>
                <div
                    class="ccm-custom-style-container ccm-custom-style-contenido3135-491 ccm-block-custom-template-listado-clasico">
                    <div class="ccm-block-page-list-clasico">
                        <div class="ccm-block-page-list-header">
                            <h6 class="pb-3">Principales secciones</h6>
                            <?php wp_nav_menu(array(
                                           'theme_location' =>'listados',
                                           'menu_id'=>'sd-menu',
                                        )); ?>


                        </div>
                    </div>
                </div>
        <div class="container">
                <div class="row">
                    <h6 class="pb-3">Otros Accesos</h6>

                    <?php dynamic_sidebar('accesibility-sidebar-izq') ?>
                </div>
        </div>
            </div>
        </div>
    </div>
<div class="separador"> </div> 
    <div class="container">
        <div class="col-sm-12">
     


        </div>
    </div>

</main>

<?php get_footer() ?>