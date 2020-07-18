<?php

/**
 * Handles products fields
 */

if (!class_exists('TTC_Product_Fields')) {
    class TTC_Product_Fields
    {
        /**
         * Register meta box
         *
         * @return void
         */
        public function register()
        {
            add_meta_box(
                TTC_THEME_PREFIX . 'product-field', // $id
                'Product Fields',                   // $title
                array($this, 'meta_box_html'),      // $callback
                TTC_THEME_PREFIX . 'product',       // $page
                'side',                           // $context 
            );
        }

        /**
         * Returns fields definition array
         *
         * @return array
         */
        private function get_product_fields()
        {
            return
                array(
                    array(
                        'label' => 'Price',
                        'desc'  => 'Product regular price',
                        'name'    => TTC_THEME_PREFIX . 'price',
                        'type'  => 'number'
                    ),
                    array(
                        'label' => 'Sale Price',
                        'desc'  => 'Product sale price. ',
                        'name'    => TTC_THEME_PREFIX . 'sale-price',
                        'type'  => 'number'
                    ),
                    array(
                        'label' => 'Is On Sale?',
                        'desc'  => 'Check this to use sale price instead of regular price. ',
                        'name'    => TTC_THEME_PREFIX . 'is-on-sale',
                        'type'  => 'checkbox'
                    ),
                    array(
                        'label' => 'Youtube Video',
                        'desc'  => 'Product video url',
                        'name'    => TTC_THEME_PREFIX . 'youtube',
                        'type'  => 'youtube'
                    ),
                    array(
                        'label' => 'Gallery Images',
                        'desc'  => 'Product gallery images.',
                        'name'    => TTC_THEME_PREFIX . 'gallery',
                        'type'  => 'gallery'
                    ),
                );
        }

        /**
         * Creates the HTML for the meta box in product edit page
         *
         * @return void
         */
        public function meta_box_html()
        {
            global $post;
            $fields = $this->get_product_fields();

            // nonce for verification
            wp_nonce_field(TTC_THEME_PREFIX . 'product_fields', TTC_THEME_PREFIX . 'product_fields_nonce');


            echo '<table class="form-table">';
            foreach ($fields as $field) {

                $meta = get_post_meta($post->ID, $field['name'], true);

                // Row start
                echo '<tr>
                <th><label for="' . $field['name'] . '">' . $field['label'] . '</label><br></th>
                <td>';
                switch ($field['type']) {
                    case 'number':
                        echo '<input type="number" id="' . $field['name'] . '" name="' . $field['name'] . '" min="0"  value="' . $meta . '">';
                        break;
                    case 'checkbox':
                        $checked = '';
                        if ($meta == 'yes') {
                            $checked = 'checked="checked"';
                        }
                        echo '<input type="checkbox"  id="' . $field['name'] . '" name="' . $field['name'] . '" ' . $checked . '>';
                        break;
                    case 'gallery':
                        $meta_html = null;
                        if ($meta) {
                            $meta_html .= '<ul class="ttc_gallery_list">';
                            $meta_array = explode(',', $meta);
                            foreach ($meta_array as $meta_gall_item) {
                                $meta_html .= '<li><div class="ttc_gallery_container"><img id="' . esc_attr($meta_gall_item) . '" src="' . wp_get_attachment_thumb_url($meta_gall_item) . '"></div></li>';
                            }
                            $meta_html .= '</ul>';
                        }
                        echo '<input id="' . $field['name'] . '" name="' . $field['name'] . '" type="hidden" value="' . esc_attr($meta) . '" />
                           <span id="ttc_gallery_src">' . $meta_html . '</span>
                           <div class="ttc_gallery_button_container"><input id="ttc_gallery_button" type="button" value="Add Images" /></div>';
                        break;
                    case 'youtube':
                    case 'url':
                        echo '<input type="url" id="' . $field['name'] . '" name="' . $field['name'] . '" value="' . $meta . '">';
                        break;
                } //end switch
                echo '<p class="description">' . $field['desc'] . '</p></td></tr>'; //end row

            } // end foreach
            echo '</table>'; // end table
        }

        /**
         * called when a product is saved. saves values in postmeta table
         *
         * @param int $post_id
         * @return void
         */
        public function save_post($post_id)
        {
            $fields = $this->get_product_fields();
            foreach ($fields as $field) {

                $value = isset($_POST[$field['name']]) ? $_POST[$field['name']] : false;

                switch ($field['type']) {
                    case 'gallery':
                        $value = sanitize_text_field($value);
                        $ids = explode(',', $value);
                        $ids_filtered = array_filter($ids, 'is_numeric');
                        $value = implode(',', $ids_filtered);
                        break;
                    case 'text':
                        $value = sanitize_text_field($value);
                        break;
                    case 'url':
                        if ($value) {
                            $value = esc_url($value);
                        }
                        break;
                    case 'youtube':
                        if ($value) {
                            $value = esc_url($value);
                            if (strpos($value, 'youtube.com') === false && strpos($value, 'youtu.be') === false) {
                                $value = false;
                            }
                        }
                        break;
                    case 'number':
                        if ($value) {
                            $value = floatval($value);
                        }
                        break;
                    case 'checkbox':
                        if ($value) {
                            $value = 'yes';
                        } else {
                            $value = 'no';
                        }
                        break;
                }

                if ($value) {
                    update_post_meta($post_id, $field['name'], $value);
                }
            }
        }
    } // end of class


    /**
     * Hooks
     */

    /**
     * Registres meta box and fields
     */
    function add_product_fields()
    {
        $meta_box = new TTC_Product_Fields();
        $meta_box->register();
    }
    add_action('add_meta_boxes', 'add_product_fields');

    /**
     * Admin scripts
     */
    function ttc_load_wp_admin_style()
    {
        wp_enqueue_media();
        wp_enqueue_script('media-upload');
        wp_enqueue_script(TTC_THEME_PREFIX . 'admin_script', get_stylesheet_directory_uri() . '/assets/js/admin.js');
    }
    add_action('admin_enqueue_scripts', 'ttc_load_wp_admin_style');

    /**
     * Handles saved product
     *
     * @param int $post_id 
     */
    function ttc_save_product($post_id)
    {
        if (get_post_type($post_id) == TTC_THEME_PREFIX . 'product') {
            if (
                !isset($_POST[TTC_THEME_PREFIX . 'product_fields_nonce'])
                || !wp_verify_nonce($_POST[TTC_THEME_PREFIX . 'product_fields_nonce'], TTC_THEME_PREFIX . 'product_fields')
            ) {
                return;
            }

            $product_fields = new TTC_Product_Fields();
            $product_fields->save_post($post_id);
        }
    }
    add_action('save_post', 'ttc_save_product');
}