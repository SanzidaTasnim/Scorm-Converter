<?php

namespace Sanzida\Scorm\App;

/**
 * Front Class
 */
class Front {

    /**
     * class constructor
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'front_enqueue'] );
    }
    /**
     * Enqueuing Front Files
     */
    public function front_enqueue() {
        //Enqueue all css
        wp_enqueue_style( 'front-scorm-css', SCORM_ASSET . '/front/css/front.css', '', time(), 'all' );

        //Enqueue all js
        wp_enqueue_script( 'front-scorm-js', SCORM_ASSET . '/front/js/front.js', '', time(), 'true' );
    }

}