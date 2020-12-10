<?php

/*
Plugin Name: Contempo Real Estate 7 Payment Gateways
Plugin URI: http://contempothemes.com
Description: Loads payment gateways for WP Pro Real Estate 7 when using the front end submission system.
Version: 1.0.3
Author: Contempo
Author URI: http://contempothemes.com
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/*-----------------------------------------------------------------------------------*/
/* Load Plugin Textdomain */
/*-----------------------------------------------------------------------------------*/

add_action( 'plugins_loaded', 'ct_repg_load_textdomain' );

function ct_repg_load_textdomain() {
  load_plugin_textdomain( 'contempo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

/*-----------------------------------------------------------------------------------*/
/* Load Gateways */
/*-----------------------------------------------------------------------------------*/

//require plugin_dir_path( __FILE__ ) . 'OAuth.php';
require plugin_dir_path( __FILE__ ) . 'gateways/paypal/paypalnow.php';

function cpg_load_scripts($hook) {
    wp_enqueue_script( 'cpg-paypal', plugins_url( 'js/paypal.js', __FILE__ ), array('jquery'), '1.0.0' );
}
add_action('wp_enqueue_scripts', 'cpg_load_scripts');


?>