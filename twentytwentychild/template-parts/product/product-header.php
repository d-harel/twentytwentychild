<header class="entry-header has-text-align-center header-footer-group">
    <div class="entry-header-inner section-inner medium">
        <?php
        $badge = TTC_Products::display_sale_badge(get_the_ID());

        the_title('<h1 class="entry-title">', $badge . '</h1>');
        ?>
    </div><!-- .entry-header-inner -->
    <?php echo TTC_Products::get_pricing_display(get_the_ID()); ?>
</header><!-- .entry-header -->