<?php

namespace Alike\Admin;

/**
* Class Alike_Admin_Scripts
* @package Alike\Admin
*/
class Ra_Admin_Scripts {

  /**
   * class constructor
   *
   * @version 1.0.0
   * @since 1.0.0
   *
   * @return null
   */

  public function __construct(){
    add_action( 'admin_enqueue_scripts', array( $this, 'alike_admin_load_scripts') );
  }

  /**
   * admin script loading
   *
   * @version 1.0.0
   * @since 1.0.0
   *
   * @param $hook
   * @return null
   */

  public function alike_admin_load_scripts( $hook ) {
    $restricted_page = array(
          'toplevel_page_alike_admin'
        );
    if( in_array($hook, $restricted_page) ){

      wp_register_style('simple-line-icons-style', RA_CSS.'/simple-line-icons.css', array(), $ver = false, $media = 'all');
      wp_enqueue_style('simple-line-icons-style');

      wp_register_style('ra-admin-style', RA_CSS.'/admin.css', array(), $ver = false, $media = 'all');
      wp_enqueue_style('ra-admin-style');

      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'jquery-ui-core' );
      wp_enqueue_script( 'jquery-ui-sortable' );
      wp_enqueue_script( 'underscore' );
      wp_register_script( 'ra-backend',RA_JS.'backend.js', array('jquery','underscore','jquery-ui-core','jquery-ui-sortable'), $ver = true, true);
      wp_enqueue_script( 'ra-backend' );

      $lang = array(
        'SAVE' => esc_html__('Save', 'alike'),
        'PLEASE_SELECT_A_POST_TYPE' => esc_html__('Please select a post type', 'alike'),
        'ADD_POST_TYPES' => esc_html__('Add Post Types', 'alike'),
        'PLEASE_SELECT_POST_TYPES' => esc_html__('Please select post types', 'alike'),
        'UPDATE' => esc_html__('Update', 'alike'),
        'SHOW_RATING_BOX' => esc_html__('Show Rating Box', 'alike'),
        'SHOW_ON_TOP' => esc_html__('Show on Top', 'alike'),
      );

      wp_localize_script( 'ra-backend', 'ALIKE_ADMIN', array(
        'builder_nonce' => wp_create_nonce( 'builder_nonce' ),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'helper' => array(
          'all_post_types' => $this->ra_get_all_post_types()
        ),
        'LANG' => $lang,
      ));
    }
  }

  public function ra_get_all_post_types(){
    $post_types = get_post_types( array('public'=> true ) , 'names', 'and' );

    $all_types = array();
    foreach ($post_types as $type) {
      $all_types[] = $type;
    }

    return $all_types;
  }
}
