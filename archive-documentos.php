<?php /* plantilla del listado de direcciones */ ?>
<?php get_header() ?>
        <main id="main-content" class="mt-0">
            <div class="fondo">
                <div class="container">
                    <div class="title">
                        <h1 class="h-2">Documentos</h1>
                    </div>
    
                    <?php bootstrap_breadcrumb() ?>
                </div>
            </div>
            <div class="container mb-4">
                <section id="content">  
                    <?php
	       			$args=$wp_query->query_vars;
	       		    $args['orderby']='date';
	       		    $args['order']='ASC';
	       		    $args['posts_per_page']='5';
	                query_posts($args);
	       		?>
      <div class="col-sm-12">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					
					        <li class="listado">			        	<h4><a href="<?php the_permalink(); ?>"  style="text-align:center;"><?php the_title(); ?></a></h4>
					        	<a href="<?php the_permalink(); ?>" class="leermas" style="display:inline;">Ver información</a>
					        </li>
					       
					<?php endwhile; else: ?>
					    <li>No hay contenido en esta seccion.</li>
					<?php endif; ?>

				</ul>


                </section>
                </div>
            </div>
        </main>
                                  <?php echo bootstrap_pagination(); ?>

<?php get_footer(); ?>           
          