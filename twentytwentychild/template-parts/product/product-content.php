<?php
$gallery = get_post_meta(get_the_ID(), TTC_THEME_PREFIX . 'gallery', true);
$youtube = get_post_meta(get_the_ID(), TTC_THEME_PREFIX . 'youtube', true);
?>
<div class="content">
    <div class="gallery">
        <?php echo do_shortcode('[gallery ids="' . $gallery . '"  columns="0" link="none"]'); ?>
    </div>
    <div class="entry-content">
        <?php
        the_content();
        ?>
    </div><!-- .entry-content -->
    <?php if ($youtube) { ?>
    <div class="youtube">
        <?php echo wp_oembed_get($youtube); ?>
    </div>
    <?php } ?>
</div><!-- .post-content -->