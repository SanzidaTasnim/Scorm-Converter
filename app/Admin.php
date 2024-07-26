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
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
    }

    /**
     * Admin Enqueue Assets
     */
    public function admin_enqueue()
    {
        //Enqueue all css
        wp_enqueue_style( 'admin-scorm-css', SCORM_ASSET . '/admin/css/admin.css', '', time(), 'all' );
        //Enqueue all js
        wp_enqueue_script( 'admin-scorm-js', SCORM_ASSET . '/admin/js/admin.js', '', time(), 'true' );
    }

}
