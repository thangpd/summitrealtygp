<?php
/*
 * Plugin Name: Contempo Compare Listings
 * Plugin URI: http://contempothemes.com
 * Description: A plugin to add compare functionality for listings
 * Version: 1.0.6
 * Author: Contempo
 * Author URI: http://www.contempothemes.com
 * Requires at least: 3.6
 * Tested up to: 4.7
 *
 * Text Domain: alike
 * Domain Path: /languages/
 * 
 * Copyright: 
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * 
 */

if(!defined('ABSPATH')) exit; // Exit if accessed directly
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class Redq_Alike
 */
class Redq_Alike {

    /**
     * @var null
     */
    protected static $_instance = null;


    /**
     * @create instance on self
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function __construct(){

        $this->ra_load_all_classes();
        $this->ra_app_bootstrap();
        add_action( 'plugins_loaded', array( &$this, 'ra_language_textdomain' ),1 );
    }


    /**
     *  App Bootstrap
     *  Fire all class
     */
    public function ra_app_bootstrap(){


        /**
         * Define plugin constant
         */
        define( 'RA_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'RA_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
        define( 'RA_FILE', __FILE__ );

        define( 'RA_CSS' , RA_URL.'/assets/dist/css/' );
        define( 'RA_JS' ,  RA_URL.'/assets/dist/js/' );
        define( 'RA_IMG' ,  RA_URL.'/assets/dist/img/' );
        define( 'RA_VEN' , RA_URL.'/assets/vendor/' );
        define( 'RA_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . 'templates/' );


        // ALL CLASS WILL BE LOADED FROM HERE ()

        /**
        * admin part
        */

        new Alike\Admin\Ra_Admin();         // admin initialization
        new Alike\Admin\Ra_Admin_Scripts(); // admin scripts
        //new Alike\Admin\Ra_Admin_Provider(); // admin data provider
        new Alike\App\Ra_Install();          // TextDomain , install hook
        new Alike\App\Ra_Shortcodes();
        new Alike\App\Ra_Frontend_Scripts();
        new Alike\App\Ra_Ajax();
        // new comparison\App\Re_Ajax_Builder();


        add_action( 'widgets_init', function(){
          register_widget( 'Alike\App\Ra_Alike_Widget' );
        });

    }

    /**
   	 * Load all the classes with composer auto loader
   	 *
   	 * @return void
  	 */
    public function ra_load_all_classes(){

        include_once __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
        include_once __DIR__.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'alike-helper-function.php';

    }

    /**
     * Get the template path.
     * @return string
     */
    public function template_path() {
        return apply_filters( 'alike_template_path', 'alike/' );
    }

    /**
     * Get the plugin path.
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }

    /**
     * Get the plugin textdomain for multilingual.
     * @return null
     */
    public function ra_language_textdomain() {
        load_plugin_textdomain( 'alike', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

}


/**
 * Main instance of alike.
 *
 * Returns the main instance of RA to prevent the need to use globals.
 *
 * @since  1.0
 * @return Redq_Alike
 */
function RA() {
    return Redq_Alike::instance();
}

// Global for backwards compatibility.
$GLOBALS['alike'] = RA();
