<?php

namespace Sanzida\WPCategory\App;

/**
 * Admin Class
 */
class Admin
{

    /**
     * class constructor
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
        add_action( 'product_cat_add_form_fields', [ $this, 'add_custom_fields_to_category' ] );
        add_action( 'product_cat_edit_form_fields', [ $this, 'edit_custom_fields_in_category' ], 10, 2);
        add_action( 'created_product_cat', [ $this, 'save_custom_fields_in_category' ], 10, 2 );
        add_action( 'edited_product_cat', [ $this, 'save_custom_fields_in_category' ], 10, 2 );

        add_action( 'admin_head', [ $this, "form_multipart" ] );
    }

    /**
     * Admin Enqueue Assets
     */
    public function admin_enqueue() {
        //Enqueue all css
        wp_enqueue_style( 'admin-category-css', WP_CATEGORY_ASSET . '/admin/css/admin.css', '', time(), 'all' );
        //Enqueue all js
        wp_enqueue_script( 'admin-category-js', WP_CATEGORY_ASSET . '/admin/js/admin.js', '', time(), 'true' );
    }

    public function add_custom_fields_to_category($taxonomy) {
        ?>
        <div class="form-field">
            <label for="custom_textarea"><?php _e('Custom Textarea', 'woocommerce'); ?></label>
            <textarea name="custom_textarea" id="custom_textarea" rows="5" cols="40"></textarea>
        </div>
        <div class="form-field">
            <label for="custom_image"><?php _e('Custom Image', 'woocommerce'); ?></label>
            <input type="file" name="custom_image" id="custom_image">
        </div>
        <?php
    }
    
    public function edit_custom_fields_in_category($term, $taxonomy) {
        $custom_textarea = get_term_meta($term->term_id, 'custom_textarea', true);
        $custom_image = get_term_meta($term->term_id, 'custom_image', true);
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="custom_textarea"><?php _e('Custom Textarea', 'woocommerce'); ?></label></th>
            <td>
                <textarea name="custom_textarea" id="custom_textarea" rows="5" cols="50"><?php echo esc_textarea($custom_textarea); ?></textarea>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="custom_image"><?php _e('Custom Image', 'woocommerce'); ?></label></th>
            <td>
                <input type="file" name="custom_image" id="custom_image">
                <?php if ($custom_image) : ?>
                    <br><img src="<?php echo esc_url(wp_get_attachment_url($custom_image)); ?>" style="max-width: 250px;">
                <?php endif; ?>
            </td>
        </tr>
        <?php
    }
    

    public function save_custom_fields_in_category($term_id) {
        if (isset($_POST['custom_textarea'])) {
            update_term_meta($term_id, 'custom_textarea', sanitize_text_field($_POST['custom_textarea']));
        }
    
        if (isset($_FILES['custom_image']) && !empty($_FILES['custom_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
    
            $attachment_id = media_handle_upload('custom_image', 0);
    
            if (!is_wp_error($attachment_id)) {
                update_term_meta($term_id, 'custom_image', $attachment_id);
            } else {
                error_log('Image upload failed: ' . $attachment_id->get_error_message());
            }
        } else {
            error_log('No file uploaded or file array key is missing.');
        }
    }

    public function form_multipart(){
        if (isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'product_cat') {
            echo '<script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function() {
                    var form = document.querySelector("#edittag, #addtag");
                    if (form) {
                        form.enctype = "multipart/form-data";
                    }
                });
            </script>';
        }
    }

}
