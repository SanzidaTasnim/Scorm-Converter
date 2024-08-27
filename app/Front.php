<?php

namespace Sanzida\WPCategory\App;

/**
 * Front Class
 */
class Front {

    /**
     * class constructor
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'front_enqueue' ] );
        add_action( 'woocommerce_before_main_content', [ $this, 'display_custom_fields_in_category' ], 20 );
    }
    /**
     * Enqueuing Front Files
     */
    public function front_enqueue() {
        //Enqueue all css
        wp_enqueue_style( 'front-category-css', WP_CATEGORY_ASSET . '/front/css/front.css', '', time(), 'all' );

        //Enqueue all js
        wp_enqueue_script( 'front-category-js', WP_CATEGORY_ASSET . '/front/js/front.js', '', time(), 'true' );
    }

    public function display_custom_fields_in_category() {
        if (is_product_category()) {
            $term = get_queried_object();
            $custom_textarea = get_term_meta($term->term_id, 'custom_textarea', true);
            $custom_image = get_term_meta($term->term_id, 'custom_image', true);
    
            if ($custom_image) {
                $image_url = esc_url(wp_get_attachment_url($custom_image));
            }
    
            // Split the custom_textarea into words
            $words = explode(' ', $custom_textarea);
            $initial_text = implode(' ', array_slice($words, 0, 20)); // Display the first 20 words
            $remaining_text = implode(' ', array_slice($words, 20));
    
            echo '<div class="custom-category-wrapper" style="position: relative; overflow: hidden;">';
            if (!empty($image_url)) {
                echo '<div class="custom-category-image" style="background-image: url(' . $image_url . '); position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center;"></div>';
            }
            if ($custom_textarea) {
                echo '<div class="custom-category-textarea" style="position: relative; color: white; text-align: center; padding: 20px;">';
                echo '<span class="initial-text">' . esc_html($initial_text) . '</span>';
                if (!empty($remaining_text)) {
                    echo '<span class="remaining-text" style="display:none;">' . esc_html($remaining_text) . '</span>';
                    echo '<br><a href="#" class="show-more" style="color: white; text-decoration: underline;">▼</a>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
    }

}