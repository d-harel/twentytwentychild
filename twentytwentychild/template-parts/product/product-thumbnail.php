 <?php
    if (has_post_thumbnail()) {
    ?>
 <figure class="featured-media">
     <div class="featured-media-inner section-inner">
         <?php
                the_post_thumbnail();
                ?>
     </div><!-- .featured-media-inner -->
 </figure><!-- .featured-media -->
 <?php } ?>