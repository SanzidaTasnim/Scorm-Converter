<?php 
/*
 * Plugin Name:       Scorm Converter
 * Plugin URI:        
 * Description:       Converting course content to scorm file.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sanzida Tasnim
 * Author URI:        https://github.com/SanzidaTasnim
 * Text Domain:       scorm-converter
*/

namespace Sanzida\Scorm;

if( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Plugin main class
 */ 
final class ScormConverter {
    static $instance = false;

    /**
     * class constructor
     */
    private function __construct() {
        
        $this->include();
        $this->define();
        $this->hooks();
    }

    /**
     * Include all needed files
     */
    public function include() {
        require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
        require_once( dirname( __FILE__ ) . '/inc/functions.php' );
    }

    /**
     * define all constant
     */
    private function define() {
        define( 'SCORM', __FILE__ );
        define( 'SCORM_DIR', dirname( SCORM ) );
        define( 'SCORM_ASSET', plugins_url( 'assets', SCORM ) );
    }

    /**
     * All hooks
     */
    private function hooks() {
        new App\Admin();
        new App\Front();
        new App\Shortcode();
    }

    /**
     * Singleton Instance
    */
    static function get_esent_plugin() {
        
        if( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

/**
 * Cick off the plugins 
 */
ScormConverter::get_esent_plugin();