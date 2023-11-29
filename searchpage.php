<?php
/**
 * Template Name: Search Page
 */

global $wp_query;
$total_results = $wp_query->found_posts;

$s=get_search_query();
$args = array(
    's' => $s
);
$the_query = new WP_Query($args);

get_header() ?>

<main id="main-content" class="mt-5 mb-5">
    <?php if ($the_query->have_posts()): ?>
            <div class="container">
                <div class="row">
                    <div class="col-sx-12 col-md-8">
                        <section id="content">                   
                            <div class="feed">
                                <?php while ($the_query->have_posts()): ?>
                                    <?php $the_query->the_post() ?>
                                        <?php the_title() ?>
                                    <?php get_template_part('content', 'search'); ?>
                                <?php endwhile ?>

                                <?php echo bootstrap_pagination(); ?>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
    <?php endif ?>
</main>


<?php get_footer() ?>