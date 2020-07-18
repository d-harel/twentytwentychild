<?php

/**
 * Handles products registration and access
 */

use function PHPSTORM_META\map;

if (!class_exists('TTC_Products')) {
    class TTC_Products
    {
        /**
         * Handles post type registation
         *
         * @return void
         */
        public static function register()
        {
            self::register_product_post_type();
            self::register_product_categories();

            add_shortcode('ttc_product_box', array('TTC_Products', 'do_product_box_shortcode'));
        }

        /**
         * Register Product post type 
         *
         * @return void
         */
        private static function register_product_post_type()
        {
            $labels = array(
                'name'                  => _x('Products', 'Post Type General Name', 'twentytwentychild'),
                'singular_name'         => _x('Product', 'Post Type Singular Name', 'twentytwentychild'),
                'menu_name'             => __('Products', 'twentytwentychild'),
                'name_admin_bar'        => __('Product', 'twentytwentychild'),
                'archives'              => __('Product Archives', 'twentytwentychild'),
                'attributes'            => __('Product Attributes', 'twentytwentychild'),
                'parent_item_colon'     => __('Parent Product:', 'twentytwentychild'),
                'all_items'             => __('All Products', 'twentytwentychild'),
                'add_new_item'          => __('Add New Product', 'twentytwentychild'),
                'add_new'               => __('New Product', 'twentytwentychild'),
                'new_item'              => __('New Product', 'twentytwentychild'),
                'edit_item'             => __('Edit Product', 'twentytwentychild'),
                'update_item'           => __('Update Product', 'twentytwentychild'),
                'view_item'             => __('View Product', 'twentytwentychild'),
                'view_items'            => __('View Products', 'twentytwentychild'),
                'search_items'          => __('Search products', 'twentytwentychild'),
                'not_found'             => __('No products found', 'twentytwentychild'),
                'not_found_in_trash'    => __('No products found in Trash', 'twentytwentychild'),
                'featured_image'        => __('Main Image', 'twentytwentychild'),
                'set_featured_image'    => __('Set main image', 'twentytwentychild'),
                'remove_featured_image' => __('Remove main image', 'twentytwentychild'),
                'use_featured_image'    => __('Use as main image', 'twentytwentychild'),
                'insert_into_item'      => __('Insert into product', 'twentytwentychild'),
                'uploaded_to_this_item' => __('Uploaded to this product', 'twentytwentychild'),
                'items_list'            => __('Products list', 'twentytwentychild'),
                'items_list_navigation' => __('Products list navigation', 'twentytwentychild'),
                'filter_items_list'     => __('Filter products list', 'twentytwentychild'),
            );
            $args = array(
                'label'                 => __('Product', 'twentytwentychild'),
                'description'           => __('Product management', 'twentytwentychild'),
                'labels'                => $labels,
                'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 10,
                'menu_icon'             => 'dashicons-cart',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                'show_in_rest'          => true,
            );
            register_post_type(TTC_THEME_PREFIX . 'product', $args);
        }

        /**
         * Register product custom taxonomy 
         *
         * @return void
         */
        private static function register_product_categories()
        {
            $labels = array(
                'name'                       => _x('Categories', 'Taxonomy General Name', 'twentytwentychild'),
                'singular_name'              => _x('Category', 'Taxonomy Singular Name', 'twentytwentychild'),
                'menu_name'                  => __('Categories', 'twentytwentychild'),
                'all_items'                  => __('All Categories', 'twentytwentychild'),
                'parent_item'                => __('Parent Category', 'twentytwentychild'),
                'parent_item_colon'          => __('Parent Category:', 'twentytwentychild'),
                'new_item_name'              => __('New Category Name', 'twentytwentychild'),
                'add_new_item'               => __('Add New Category', 'twentytwentychild'),
                'edit_item'                  => __('Edit Category', 'twentytwentychild'),
                'update_item'                => __('Update Category', 'twentytwentychild'),
                'view_item'                  => __('View Category', 'twentytwentychild'),
                'separate_items_with_commas' => __('Separate Categories with commas', 'twentytwentychild'),
                'add_or_remove_items'        => __('Add or remove Categories', 'twentytwentychild'),
                'choose_from_most_used'      => __('Choose from the most used', 'twentytwentychild'),
                'popular_items'              => __('Popular Categories', 'twentytwentychild'),
                'search_items'               => __('Search Categories', 'twentytwentychild'),
                'not_found'                  => __('Not Found', 'twentytwentychild'),
                'no_terms'                   => __('No Categories', 'twentytwentychild'),
                'items_list'                 => __('Categories list', 'twentytwentychild'),
                'items_list_navigation'      => __('Categories list navigation', 'twentytwentychild'),
            );
            $args = array(
                'labels'                     => $labels,
                'hierarchical'               => true,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => false,
                'show_in_rest'               => true,
            );
            register_taxonomy(TTC_THEME_PREFIX . 'category', array(TTC_THEME_PREFIX . 'product'), $args);
        }

        /**
         * Returns sale badge HTML if the product is on sale
         *
         * @param int $product_id
         * @return string
         */
        public static function display_sale_badge($product_id)
        {
            $on_sale = '';
            $checkbox = get_post_meta($product_id, TTC_THEME_PREFIX . 'is-on-sale', true);
            $color = twentytwenty_get_color_for_area('content', 'accent');
            if ($checkbox == 'yes') {
                $on_sale = '<div class="sale" style="background:' . $color . '">' . __('Sale!', 'twentytwentychild') . '</div>';
            }

            return $on_sale;
        }

        /**
         * Returns all visible products
         *
         * @param int       $max_products   Optional. How many products to return. 
         *                                  -1 for all products. default '-1'.
         * @return array                    Array of posts.
         */
        public static function get_all_products($max_products = -1)
        {
            $args = array(
                'post_type' => TTC_THEME_PREFIX . 'product',
                'post_status' => 'publish',
                'posts_per_page' => $max_products,
                'orderby' => 'title',
                'order' => 'ASC',
            );
            $query = new WP_Query($args);
            return $query->posts;
        }

        /**
         * Returns all related products to a specific product. 
         * Related = in the same categories.
         *
         * @param int           $product_id     The product.
         * @param int           $max_products   Optional. How many products to return. 
         *                                      -1 for all products. default '-1'.                  
         * @param array|boolean $category_ids   Array of product categories ids. False for all of the product 
         *                                      categories. Default 'false'.
         * @return array                        Array of posts.
         */
        public static function get_related_products($product_id, $max_products = -1, $category_ids = false)
        {
            if ($category_ids === false) {
                $categories = wp_get_post_terms($product_id, TTC_THEME_PREFIX . 'category');
                if (!$categories || is_wp_error($categories)) {
                    return false;
                }

                $category_ids = array_column($categories, 'term_id');
            }

            $args = array(
                'post_type' => TTC_THEME_PREFIX . 'product',
                'posts_per_page' => $max_products,
                'post__not_in' => array($product_id),
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => TTC_THEME_PREFIX . 'category',
                        'field'    => 'term_id',
                        'terms'    => $category_ids,
                    ),
                )
            );
            $query = new WP_Query($args);
            return $query->posts;
        }

        /**
         * Returns product pricing with regular + sale price 
         *
         * @param int $product_id
         * @return string
         */
        public static function get_pricing_display($product_id)
        {
            $html = '<div class="pricing">';
            $price = get_post_meta($product_id, TTC_THEME_PREFIX . 'price', true);
            $sale_price = get_post_meta($product_id, TTC_THEME_PREFIX . 'sale-price', true);
            $checkbox = get_post_meta($product_id, TTC_THEME_PREFIX . 'is-on-sale', true);
            if ($checkbox == 'no') {
                $html .= '<span class="regular-price">$' . $price . '</span>';
            } else {
                $html .= '<span class="regular-price stroke">$' . $price . '</span> <span class="sale-price">$'
                    .  $sale_price . '</span>';
            }

            $html .= '</div>';
            return $html;
        }

        /**
         * Handles shortcode ttc_product_box
         * Returns HTML for Product box
         *
         * @param array $atts       Attributes: 
         *                          product_id  -   The product to display
         *                          bg_color    -   The color for box background
         * @return string
         */
        public static function do_product_box_shortcode($atts = array())
        {
            $params = shortcode_atts(array(
                'product_id' => 0,
                'bg_color' =>  twentytwenty_get_color_for_area('content', 'accent')
            ), $atts);

            if (!$params['product_id']) {
                return '';
            }
            $badge = TTC_Products::display_sale_badge($params['product_id']);
            $pricing = TTC_Products::get_pricing_display($params['product_id']);
            $html =
                '<div class="product-box">
                <div class="product-inner" style="background:' . $params['bg_color'] . '">'
                . $badge
                . get_the_post_thumbnail($params['product_id'], 'thumbnail')
                . '<div class="product-title">'
                . get_the_title($params['product_id'])
                . '</div>'
                . $pricing
                . '</div> 
             </div>';

            return $html;
        }
    }
}