<?php /* plantilla utilizada para listar las noticias */ ?>
<style>
.separador_post { padding-bottom: 15px;
    margin-bottom: 15px;
    border-bottom: 1px solid #ececec;}

</style>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="publicestirar clearfix">
       
        <?php if(has_post_thumbnail(get_the_ID())){ ?> <a href="<?php the_permalink(); ?>"> 
            <a href="<?php the_permalink(); ?>" class="">
            <?php echo get_the_post_thumbnail( get_the_ID(), 'bloqecitos_thumb foto_portada_item descriptivo' ); ?>
            <div class="modulo">    <h4> <a href="<?php the_permalink(); ?>"style="font-size:20px; font-family: 'GaramondPremrPro';">  <?php the_title(); ?></a></h4>
            </a>
        <?php } ?> 
            
        <?php include('infonoti.php'); ?>
  
        <?php the_excerpt(); ?>
    </div>
    <div class="separador_post"></div>
        <br class="clearfix">
    </div>
<?php endwhile; else: ?>
    <h1>No hay contenido en esta seccion.</h1>
<?php endif; ?>

   
<p style="text-align: center;"><a class="btn btn-outline btn-outline-primary"
                                    href="https://www.muvh.gov.py/noticias">Ver Más +</a></p>