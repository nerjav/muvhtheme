<?php get_header() ?>

<main id="main-content" class="mt-5 mb-5">
    <?php if (have_posts()): ?>
            <div class="container">
                <div class="row">
                    <div class="col-sx-12 col-md-8">
                        <section id="content">                   
                            <div class="feed">
                                <?php while (have_posts()): ?>
                                    <?php the_post() ?>
                                    <article class="item item-normal">
                                        <div class="item-picture">
                                            <a href="<?php the_permalink() ?>">
                                                <?php the_post_thumbnail() ?>
                                            </a>
                                        </div>
                
                                        <div class="item-info">
                                            <div class="item-title">
                                                <a href="<?php the_permalink() ?>">
                                                    <h2><?php the_title() ?></h2>
                                                </a>
                                            </div>
                
                                            <div class="item-date">
                                                <p><?php the_date() ?></p>
                                            </div>
                
                                            <div class="item-summary">
                                                <?php the_excerpt() ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile ?>

                                <?php echo bootstrap_pagination(); ?>
                            </div>
                        </section>
                    </div>

                    <div class="col-sx-12 col-md-4 mt-3">
                        <section aria-labelledby="tags-label">
                            <div class="tags-container mb-3" aria-label="Etiquetas">
                                <h2 id="tags-label" class="h-5">Etiquetas</h2>
                                <div class="tags-list">
                                    <a class="tag-item" href="#">
                                        Tecnología
                                    </a>
                                    <a class="tag-item" href="#">
                                        Aplicación Móvil
                                    </a>
                                    <a class="tag-item" href="#">
                                        Trabajo
                                    </a>
                                    <a class="tag-item" href="#">
                                        Creación
                                    </a>
                                    <a class="tag-item" href="#">
                                        Aprendizaje
                                    </a>

                                </div>
                            </div>
                        </section>

                        <section aria-labelledby="archive-label">
                            <div class="archive-container mt-3"  aria-label="Enlaces de Archivo">
                                <h2 id="archive-label" class="h-5">Archivo</h2>
                                <ul class="nav flex-column">
                                    <li class="nav-item"><a href="#">Todas</a></li>
                                    <li class="nav-item"><a href="#">Julio 2019</a></li>
                                </ul>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
    <?php endif ?>
</main>

<?php get_footer() ?>