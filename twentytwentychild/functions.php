<?php

// Enqueue Scripts
function ttc_register_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'ttc_register_styles');

// Remove Admin Bar for specific users
function ttc_show_admin_bar($show)
{
    // For future use - add user names here
    $remove_for_users = ['wp-test'];
    $user = wp_get_current_user();
    if (in_array($user->user_login, $remove_for_users)) {
        $show = false;
    }
    return $show;
}

add_filter('show_admin_bar', 'ttc_show_admin_bar');