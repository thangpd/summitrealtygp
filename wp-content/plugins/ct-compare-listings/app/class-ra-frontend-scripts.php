<?php

namespace Alike\App;

class Ra_Frontend_Scripts{

  public function __construct(){
    add_action('wp_enqueue_scripts', array( $this , 'alike_load_scripts' ), 20 );
  }

  public function alike_load_scripts() {

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'underscore' );

    wp_register_script( 'ra-frontend',RA_JS.'frontend.js', array('jquery', 'underscore'), $ver = true, true);
    wp_enqueue_script( 'ra-frontend' );
    
    wp_register_style('ionicons-style', RA_CSS.'/ionicons.css', array(), $ver = false, $media = 'all');
    wp_enqueue_style('ionicons-style');

    wp_register_style('ra-style', RA_CSS.'/style.css', array(), $ver = false, $media = 'all');
    wp_enqueue_style('ra-style');

    $alike_settings = get_option('alike_settings', true);
    $max_compare = ( isset( $alike_settings['max_compare'] ) ) ? $alike_settings['max_compare'] : '4';

    $lang = array(
      'YOU_CAN_COMPARE_MAXIMUM_BETWEEN_S_ITEMS' => sprintf( esc_html__('You can compare maximum between %s items.', 'alike'), $max_compare),
    );

    wp_localize_script( 'ra-frontend', 'ALIKE', array(
      'builder_nonce' => wp_create_nonce( 'builder_nonce' ),
      'ajaxurl' => admin_url('admin-ajax.php'),
      'IMG' => RA_IMG,
      'max_compare' => $max_compare,
      'LANG' => $lang,
    ));

  }

}