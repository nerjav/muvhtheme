<?php /* plantilla del listado de direcciones */ ?>
<?php get_header() ?>
        <main id="main-content" class="mt-0">
            <div class="fondo">
                <div class="container">
                    <div class="title">
                        <h1 class="h-2">Autoridades</h1>
                    </div>
    
                    <?php bootstrap_breadcrumb() ?>
                </div>
            </div>
            <div class="container mb-4">
                <section id="content">  
                   
      <div class="col-sm-12">

	  <?php
       		$args=$wp_query->query_vars;
	        $args['posts_per_page']='20';
	        query_posts($args);
            include('plantilla_directorio.php');
            $args = null;
            wp_reset_query(); 
            ?>
</div>

					

			
				</div>
                </section>
                </div>
            </div>
        </main>

<?php get_footer(); ?>           
          