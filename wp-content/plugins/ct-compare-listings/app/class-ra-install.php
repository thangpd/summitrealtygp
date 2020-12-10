<?php

namespace Alike\App;


/**
 * Class Ra_Install
 *
 * @author      RedQTeam
 * @category    Admin
 * @package     Alike\App
 * @version     1.0.0
 * @since       1.0.0
 */

class Ra_Install {

  public function __construct(){

    // install hooks 
    register_activation_hook( RA_FILE, array( &$this, 'alike_plugin_install' ) );

  }

  /**
   * For db table
   * @return [type] [description]
   */
  public function alike_plugin_install(){
    add_option('alike_settings', '');
    $alike_settings = array(
      'alike_theme_select' => 'one',
      'thumbnail_size_w'   => '400',
      'thumbnail_size_h'   => '300',
      'thumbnail_crop'     => '1',
      'max_compare'        => '4',
    );
    
    $get_settings = get_option('alike_settings', true);    
    if( empty( $get_settings ) ) {
      update_option('alike_settings', $alike_settings );
    }

    global $wpdb;
    $title = 'Compare Listings';
    $content = '[alike_preview]';
    
    $post_if = $wpdb->get_var("SELECT * FROM $wpdb->posts WHERE post_title LIKE '".$title."'");
    if( empty( $post_if ) ) {
      // Create post object
      $alike_preview = array(
        'post_title'    => $title,
        'post_content'  => $content,
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'page_template'  => 'template-compare.php'
      );
       
      // Insert the page into the database
      wp_insert_post( $alike_preview );
    }

  }

}
