<?php

if (!class_exists('TTC_Rest_API')) {

    /**
     * Extends API
     */
    class TTC_Rest_API
    {
        /**
         * Added data to product category
         *
         * @return void
         */
        public static function register()
        {
            register_rest_field(TTC_THEME_PREFIX . 'category', 'products', array(
                'get_callback' => array('TTC_Rest_API', 'get_category_products')
            ));
        }

        /**
         * Handling products in category data
         *
         * @param array $category
         * @return void
         */
        public static function get_category_products($category)
        {
            $products = array();

            $args = array(
                'post_type' => TTC_THEME_PREFIX . 'product',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => TTC_THEME_PREFIX . 'category',
                        'field'    => 'term_id',
                        'terms'    => $category['id'],
                    ),
                )
            );

            $query = new WP_Query($args);
            foreach ($query->posts as $product) {
                $data = array(
                    'id' => $product->ID,
                    'title' => $product->post_title,
                    'description' => $product->post_content,
                    'image' => get_the_post_thumbnail_url($product->ID),
                    'price' => get_post_meta($product->ID, TTC_THEME_PREFIX . 'price', true),
                    'sale_price' => get_post_meta($product->ID, TTC_THEME_PREFIX . 'sale-price', true),
                    'is_on_sale' => get_post_meta($product->ID, TTC_THEME_PREFIX . 'is-on-sale', true)
                );

                $products[] = $data;
            }
            return $products;
        }
    }

    add_action('rest_api_init', array('TTC_Rest_API', 'register'));
}