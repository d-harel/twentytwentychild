<div class="products-grid">
    <?php
    foreach ($products as $product) {
        $badge = TTC_Products::display_sale_badge($product->ID);
    ?>
    <div class="product">
        <a href="<?php echo get_permalink($product); ?>">
            <div class="product-inner">
                <?php
                    echo $badge;
                    ?>

                <?php
                    echo get_the_post_thumbnail($product->ID, 'thumbnail');
                    ?>
                <div class="product-title">
                    <?php
                        echo $product->post_title;
                        ?>
                </div>
            </div>
        </a>
    </div>
    <?php
    }
    ?>
</div>