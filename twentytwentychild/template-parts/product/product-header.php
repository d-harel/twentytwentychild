<?php
$price = get_post_meta(get_the_ID(), TTC_THEME_PREFIX . 'price', true);
?>
<header class="entry-header has-text-align-center header-footer-group">
    <div class="entry-header-inner section-inner medium">
        <?php
        $badge = TTC_Products::display_sale_badge(get_the_ID());

        the_title('<h1 class="entry-title">', $badge . '</h1>');
        ?>
    </div><!-- .entry-header-inner -->
    <div class="pricing">
        <?php
        if (empty($badge)) {
            echo '<span class="regular-price">$' . $price . '</span>';
        } else {
            $sale_price = get_post_meta(get_the_ID(), TTC_THEME_PREFIX . 'sale-price', true);
            echo '<span class="regular-price stroke">$' . $price . '</span> <span class="sale-price">$'
                .  $sale_price . '</span>';
        }
        ?>
    </div>
</header><!-- .entry-header -->