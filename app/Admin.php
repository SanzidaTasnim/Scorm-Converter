<?php

namespace Sanzida\Scorm\App;

/**
 * Admin Class
 */
class Admin
{

    /**
     * class constructor
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
        add_action( 'add_meta_boxes', [ $this, 'add_scorm_converter_metabox' ] );
        add_action( 'wp_ajax_export_course_scorm', [ $this, 'export_course_scorm' ] );
    }

    /**
     * Admin Enqueue Assets
     */
    public function admin_enqueue() {
        //Enqueue all css
        wp_enqueue_style( 'admin-scorm-css', SCORM_ASSET . '/admin/css/admin.css', '', time(), 'all' );
        //Enqueue all js
        wp_enqueue_script( 'admin-scorm-js', SCORM_ASSET . '/admin/js/admin.js', '', time(), 'true' );

        // Localize script to pass AJAX URL to JavaScript
        wp_localize_script(
            'admin-scorm-js', 
            'SCORM_AJAX', 
            array( 'ajax_url' => admin_url('admin-ajax.php') ) 
        );
    }

    public function add_scorm_converter_metabox() {
        add_meta_box(
            'custom_course_metabox_id',          
            __('Scorm Converter', 'scorm-converter'),
            [ $this, 'scorm_converter_callback' ],  
            'courses',               
            'normal',                  
            'high'                               
        );
    }

    public function scorm_converter_callback() {
        echo '<button id="export_scorm" class="button" type="button">Export as SCORM</button>';
    }

    public function export_course_scorm() {
        // Check for permissions and nonces as needed for security
        $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
        
        if (!$course_id) {
            wp_send_json_error('Invalid Course ID');
            return;
        }

        $file_url = create_scorm_package($course_id);  

        wp_send_json_success($file_url);
    }
   

}
