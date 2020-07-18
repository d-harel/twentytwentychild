<?php

define('TTC_THEME_PREFIX', 'ttc-');

// Enqueue Scripts
function ttc_register_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style(TTC_THEME_PREFIX . 'style',  get_stylesheet_uri(), 'parent-style');
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


// Include Files 
require get_theme_file_path('/classes/class-ttc-product.php');
require get_theme_file_path('/classes/class-ttc-product-fields.php');
require get_theme_file_path('/classes/class-ttc-mobile.php');
require get_theme_file_path('/classes/class-ttc-rest-api.php');

// Register the products
add_action('init', array('TTC_Products', 'register'));

// Register mobile settings
add_action('init', array('TTC_Mobile', 'init'));