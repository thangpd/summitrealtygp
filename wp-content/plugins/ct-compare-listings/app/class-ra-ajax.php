<?php

namespace Alike\App;

class Ra_Ajax {
  public function __construct() {
    $ajax_events = array(
     // 'get_all_posts' => true,
      'save_all_data' => true,
    );
    foreach ( $ajax_events as $ajax_event => $nopriv ) {
      add_action( 'wp_ajax_ra_' . $ajax_event, array( $this, $ajax_event ) );
      if ( $nopriv ) {
        add_action( 'wp_ajax_nopriv_ra_' . $ajax_event, array( $this , $ajax_event ) );
      }
    }
  }

  public function save_all_data() {
    if( isset($_POST['allData']) && !empty($_POST['allData']) ){
      $allData = $_POST['allData'];

      $option_name = 'alike_data';
      update_option( $option_name, $allData);

      $data = new \Alike\Admin\Ra_Admin_Provider();
      $result = $data->get_post_data($allData);
      if( !isset($_POST['noreturn']) )
        echo json_encode($result);
    }
    wp_die();
  }



}