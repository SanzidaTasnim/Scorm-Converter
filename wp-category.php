<?php 
/*
 * Plugin Name:       WP Category 
 * Plugin URI:        
 * Description:       Add Content to Category.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sanzida Tasnim
 * Author URI:        https://github.com/SanzidaTasnim
 * Text Domain:       wp-category
*/

namespace Sanzida\WPCategory;

if( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Plugin main class
 */ 
final class WP_category {
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
        define( 'WP_CATEGORY', __FILE__ );
        define( 'WP_CATEGORY_DIR', dirname( WP_CATEGORY ) );
        define( 'WP_CATEGORY_ASSET', plugins_url( 'assets', WP_CATEGORY ) );
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
WP_category::get_esent_plugin();