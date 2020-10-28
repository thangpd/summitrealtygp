<?php 
  $alike_data = get_option( 'alike_data' );
  $result = array();
  if ($alike_data) {
    $data = new \Alike\Admin\Ra_Admin_Provider();
    $result = $data->get_post_data($alike_data);
    
  }
  wp_localize_script( 'ra-backend', 'ALIKE_DATA', $result);
  
?>
<div id="alike-admin"></div>