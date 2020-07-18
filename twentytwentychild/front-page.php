<?php

/**
 * Homepage template 
 */

get_header();
?>

<main id="site-content" role="main">
    <header class="archive-header has-text-align-center header-footer-group">
        <div class=" section-inner medium">
            <h1 class="title"><?php _e('Products', 'twentytwentychild'); ?></h1>
        </div>
    </header><!-- .archive-header -->

    <div class="content">
        <?php
        $products = TTC_Products::get_all_products();
        include(locate_template('template-parts/products-grid.php', false, false));
        ?>
    </div>
</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();