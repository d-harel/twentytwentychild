<?php
if (!class_exists('TTC_Mobile')) {
    class TTC_Mobile
    {

        public static function init()
        {
            //Register Mobile Actions
            add_action('customize_register', array('TTC_Mobile', 'register_settings'), 99);

            // Add meta tag 
            add_action('wp_head', array('TTC_Mobile', 'add_metatag'));
        }
        public static function register_settings($wp_customize)
        {
            // Header & Footer Background Color.
            $wp_customize->add_setting(
                'ttc_mobile_address_color',
                array(
                    'default'           => '#ffffff',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'ttc_mobile_address_color',
                    array(
                        'label'   => __('Mobile Address Bar Color', 'twentytwentychild'),
                        'section' => 'colors',
                    )
                )
            );
        }

        // add theme color meta data on the <head>
        public static function add_metatag()
        {
            $color = get_theme_mod(
                'ttc_mobile_address_color',
                twentytwenty_get_color_for_area('content', 'accent')
            );

            //Chrome, Firefox
            echo '<meta name="theme-color" content="' . $color . '">';
            //tWindows Phone
            echo '<meta name="msapplication-navbutton-color" content="' . $color . '">';
            // iOS Safari - no support yet
            echo '<meta name="apple-mobile-web-app-capable" content="yes">';
            echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
        }
    }
}