<?php /* plantilla del listado de direcciones */ ?>
<?php get_header() ?>
        <main id="main-content" class="mt-0">
            <div class="fondo">
                <div class="container">
                    <div class="title">
                        <h1 class="h-2">Programas Habitacionales</h1>
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

				   <style>
				   .itemtumb {
					   float:left;
					   
								   }

				  .item-right {
				font-family:Montserrat;
				font-size:14px;




}
				   </style>
      <div class="col-sm-12">
	 
	
	 
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					
	 
 <div class="itemtumb">
					        <?php if(has_post_thumbnail(get_the_ID())){ ?> 
					            <a href="<?php the_permalink(); ?>" class="">

					                <?php echo get_the_post_thumbnail( get_the_ID(), 'bloquecitos_thumb' ); ?>
					            </a>
					        <?php }  else { ?>
					        	<a href="<?php the_permalink(); ?>" class="img-thumbnail">
					               <img src="<?php echo bloginfo('template_url'); ?>/images/sinfoto.jpg" />
					            </a>
					        <?php } ?> 
</div>
						<div class="item-right">
								
								<h4><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a><h4>
								
									<?php the_excerpt(); ?>
								
								<br class="clearfix">
							</div>
					       
					<?php endwhile; else: ?>
					    <li>No hay contenido en esta seccion.
					<?php endif; ?>
				


                </section>
				</div>
</div>
                
            </div>
        </main>
                                  <?php echo bootstrap_pagination(); ?>

<?php get_footer(); ?>           
          