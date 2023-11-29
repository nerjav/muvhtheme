<?php /* plantilla utilizada para listar una noticia */ ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h2> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
    <?php 
        if(is_single()){
            include('infonoticias.php');
        }
    ?>
        <?php if ( 'post' == get_post_type() ) { ?>
    	 <?php if(has_post_thumbnail(get_the_ID())){ ?>   
    	 <div align="center" style="margin-top:10px;" class="fotonoticia">
                <?php echo get_the_post_thumbnail( get_the_ID(), 'noticia_thumb' ); ?>
         </div>
        <?php } ?> 
    <?php } ?>
    
    <?php the_content(); ?>

    <?php if ( 'post' == get_post_type() ) { ?>
        <h3 >Imágenes de: <?php the_title(); ?></h3>
        <?php echo do_shortcode('[gallery columns="4"  link="file" group="fotos"]'); ?>
    <?php } ?> 

    <br class="clearfix">
<?php endwhile; else: ?>
    <h1>No hay contenido en esta seccion.</h1>
<?php endif; ?>