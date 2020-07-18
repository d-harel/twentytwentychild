<div class="related-products">
    <h2><?php _e('Related products', 'twentytwentychild'); ?></h2>
    <?php
    $products = TTC_Products::get_related_products(get_the_ID(), 6);
    include(locate_template('template-parts/products-grid.php', false, false));
    ?>
</div>