<?php get_header() ?>

<?php if (have_posts()): ?>
    <?php while (have_posts()): the_post()?>
        <main id="main-content" class="mt-0">
            <div class="fondo">
                <div class="container">
                    <div class="title">
                        <h1 class="h-2"><?php the_title() ?></h1>
                    </div>
    
                    <?php bootstrap_breadcrumb() ?>
                </div>
            </div>
            <div class="container mb-4">
                <section id="content">  
                    <?php the_content(); ?>
                </section>
            </div>
        </main>
    <?php endwhile?>
<?php endif ?>

<?php get_footer() ?>