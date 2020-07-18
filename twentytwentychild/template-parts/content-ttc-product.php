<?php

/**
 * Product display
 */
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <?php
    get_template_part('template-parts/product/product-header');
    get_template_part('template-parts/product/product-thumbnail');
    get_template_part('template-parts/product/product-content');

    ?>
</article><!-- .ttc-product -->
<div class="post-article">
    <?php
    get_template_part('template-parts/product/product-related');
    ?>
</div>
<?php
edit_post_link();
?>