<?php get_header() ?>
<div class="fondo">
    <div class="container">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-8">
                    <div class="title">

                        <h1 class="h-2"><?php the_title() ?></h1>
                        <?php echo bootstrap_breadcrumb() ?>

                    </div>
                    
                </div>
                <div class="col-sm-4">
                <?php 
        if(is_single()){
            include('infonotip.php');
        }
    ?>
                    </div>

            </div>
        </div>
    </div>
</div>

<main id="main-content" class="mt-5 mb-5">

    <div class="container">

        <div class="row">
            <div class="col-sx-12 col-md-8">
                <section id="content">
                    <article>
                        <?php get_template_part('template-parts/content', 'article') ?>

                        <div class="slider single-item">

                            <?php if ( has_post_thumbnail() ) {
                                 the_post_thumbnail('post-tumbnail');
                                                                        } ?>
                        </div>

                        <div class="share-actions">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="https://www.facebook.com/MUVHParaguay"
                                        aria-label="Enlace al Facebook del MUVH">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="http://instagram.com/muvhpy"
                                        aria-label="Enlace al Instagram del MUVH, abre en una nueva ventana"
                                        target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://twitter.com/Muvhpy"
                                        aria-label="Enlace al Twitter del MUVH, abre en una nueva ventana"
                                        target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.youtube.com/channel/UChQ-fEtvSZSqCyDHKCVLLew"
                                        aria-label="Enlace al Youtube del MUVH, abre en una nueva ventana"
                                        target="_blank">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" aria-label="Enlace al Flickr del MUVH, abre en una nueva ventana"
                                        target="_blank">
                                        <i class="fab fa-flickr"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </article>
                </section>
            </div>

            <div class="col-sx-12 col-md-4 mt-3 mt-md-0 ">
                <div class="fondo1">
                    <section aria-labelledby="tags-label">
                        <div class="tags-container mb-3" aria-label="Etiquetas">
                            <h2 id="tags-label" class="h-5">Etiquetas</h2>
                            <div class="tags-list">
                                <?php foreach (get_tags() as $tag):?>
                                <a class="tag-item" href="<?php echo get_tag_link($tag->term_id) ?>">
                                    <?php echo $tag->name ?>
                                </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </section>

                    <section aria-labelledby="archive-label">
                        <div class="archive-container mt-3" aria-label="Enlaces de Archivo">
                            <h2 id="archive-label" class="h-5">Categorías</h2>
                            <ul class="nav flex-column">
                                <?php foreach (get_categories() as $category): ?>
                                <li class="nav-item">
                                    <a
                                        href="<?php echo get_category_link($category->term_id) ?>"><?php echo $category->name ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>


</main>

<?php get_footer() ?>