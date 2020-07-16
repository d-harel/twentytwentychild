<?php

function twentytwentychild_register_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'twentytwentychild_register_styles');