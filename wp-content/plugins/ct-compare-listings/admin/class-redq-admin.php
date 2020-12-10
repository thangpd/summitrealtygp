<?php

namespace Alike\Admin;


/**
 * Class Alike_Admin
 * @package Alike\Admin
 */
class Ra_Admin{
  /**
   * class constructor
   * @version 1.0.0
   * @since 1.0.0
   */
  public function __construct(){

    add_action( 'admin_menu', array( $this , 'ra_admin_menu')  );

    add_action( 'init', array($this, 'alike_add_new_image_size' ) );
  }

  /**
   * @return null
   */
  function alike_add_new_image_size() {
    $alike_settings = get_option('alike_settings', true);
    
    $width = $alike_settings['thumbnail_size_w'];
    $height = $alike_settings['thumbnail_size_h'];
    $crop = ( $alike_settings['thumbnail_crop'] == '1' ) ? true : false;
    
    add_image_size( 'alike_thumbnail', $width, $height, $crop );
  }

  /**
   * ra_admin_menu
   *
   * @version 1.0.0
   * @since 1.0.0
   */
  public function ra_admin_menu() {
    add_menu_page( $page_title = 'Contempo Compare Listings', $menu_title = 'CT Compare', $capability = 'manage_options', $menu_slug = 'alike_admin', $function =  array( $this , 'ra_admin_main_menu_options'),$icon_url = 'dashicons-list-view' );

    add_submenu_page( $parent_slug = 'alike_admin', $page_title = 'Settings', $menu_title='Settings', $capability = 'manage_options', $menu_slug = 'alike_settings', $function = array($this , 'ra_admin_menu_settings') );
  }

  /**
   * ra_admin_main_menu_options
   *
   * @version 1.0.0
   * @since 1.0.0
   */
  public function ra_admin_main_menu_options() {

    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'alike' ) );
    }

    include_once 'admin-templates/builder-menu-page.php';
  }

  public function ra_admin_menu_settings() {

    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'alike' ) );
    }

    include_once 'admin-templates/alike-settings.php';
  }


}
