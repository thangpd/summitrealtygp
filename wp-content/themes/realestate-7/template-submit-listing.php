<?php
/**
 * Template Name: Submit Listing
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

if(isset($_POST['draft'])) {
	$ct_auto_publish = 'draft';
} else {
	$ct_auto_publish = isset( $ct_options['ct_auto_publish'] ) ? esc_attr( $ct_options['ct_auto_publish'] ) : '';
}

$ct_google_maps_api_key = isset($ct_options['ct_google_maps_api_key'] ) ? stripslashes( $ct_options['ct_google_maps_api_key']) : '';

$ct_generate_listing_id = isset( $ct_options['ct_generate_listing_id'] ) ? esc_attr( $ct_options['ct_generate_listing_id'] ) : '';
$ct_listing_expiration = isset( $ct_options['ct_listing_expiration'] ) ? esc_attr( $ct_options['ct_listing_expiration'] ) : '';
$user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';
$postTitleError = isset( $_POST['postTitle'] ) ? $_POST['postTitle'] : '';

$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';
$ct_package_list = isset( $ct_options['ct_package_list'] ) ? esc_html( $ct_options['ct_package_list'] ) : '';
$ct_view_user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';

$ct_front_submit_street_address = isset( $ct_options['ct_front_submit_street_address'] ) ? esc_html( $ct_options['ct_front_submit_street_address'] ) : '';
$ct_front_submit_alt_title = isset( $ct_options['ct_front_submit_alt_title'] ) ? esc_html( $ct_options['ct_front_submit_alt_title'] ) : '';
$ct_front_submit_property_type = isset( $ct_options['ct_front_submit_property_type'] ) ? esc_html( $ct_options['ct_front_submit_property_type'] ) : '';
$ct_front_submit_price = isset( $ct_options['ct_front_submit_price'] ) ? esc_html( $ct_options['ct_front_submit_price'] ) : '';
$ct_front_submit_price_prefix = isset( $ct_options['ct_front_submit_price_prefix'] ) ? esc_html( $ct_options['ct_front_submit_price_prefix'] ) : '';
$ct_front_submit_price_postfix = isset( $ct_options['ct_front_submit_price_postfix'] ) ? esc_html( $ct_options['ct_front_submit_price_postfix'] ) : '';
$ct_front_submit_description = isset( $ct_options['ct_front_submit_description'] ) ? esc_html( $ct_options['ct_front_submit_description'] ) : '';
$ct_front_submit_price_postfix = isset( $ct_options['ct_front_submit_price_postfix'] ) ? esc_html( $ct_options['ct_front_submit_price_postfix'] ) : '';
$ct_front_submit_beds = isset( $ct_options['ct_front_submit_beds'] ) ? esc_html( $ct_options['ct_front_submit_beds'] ) : '';
$ct_front_submit_baths = isset( $ct_options['ct_front_submit_baths'] ) ? esc_html( $ct_options['ct_front_submit_baths'] ) : '';
$ct_front_submit_size = isset( $ct_options['ct_front_submit_size'] ) ? esc_html( $ct_options['ct_front_submit_size'] ) : '';
$ct_front_submit_lot_size = isset( $ct_options['ct_front_submit_lot_size'] ) ? esc_html( $ct_options['ct_front_submit_lot_size'] ) : '';
$ct_front_submit_pets = isset( $ct_options['ct_front_submit_pets'] ) ? esc_html( $ct_options['ct_front_submit_pets'] ) : '';
$ct_front_submit_parking = isset( $ct_options['ct_front_submit_parking'] ) ? esc_html( $ct_options['ct_front_submit_parking'] ) : '';
$ct_front_submit_property_id = isset( $ct_options['ct_front_submit_property_id'] ) ? esc_html( $ct_options['ct_front_submit_property_id'] ) : '';
$ct_front_submit_video_url = isset( $ct_options['ct_front_submit_video_url'] ) ? esc_html( $ct_options['ct_front_submit_video_url'] ) : '';
$ct_front_submit_virtual_tour = isset( $ct_options['ct_front_submit_virtual_tour'] ) ? esc_html( $ct_options['ct_front_submit_virtual_tour'] ) : '';
$ct_front_submit_open_house_date = isset( $ct_options['ct_front_submit_open_house_date'] ) ? esc_html( $ct_options['ct_front_submit_open_house_date'] ) : '';
$ct_front_submit_open_house_start_time = isset( $ct_options['ct_front_submit_open_house_start_time'] ) ? esc_html( $ct_options['ct_front_submit_open_house_start_time'] ) : '';
$ct_front_submit_open_house_end_time = isset( $ct_options['ct_front_submit_open_house_end_time'] ) ? esc_html( $ct_options['ct_front_submit_open_house_end_time'] ) : '';
$ct_front_submit_additional_features = isset( $ct_options['ct_front_submit_additional_features'] ) ? esc_html( $ct_options['ct_front_submit_additional_features'] ) : '';
$ct_front_submit_max_guests = isset( $ct_options['ct_front_submit_max_guests'] ) ? esc_html( $ct_options['ct_front_submit_max_guests'] ) : '';
$ct_front_submit_min_stay = isset( $ct_options['ct_front_submit_min_stay'] ) ? esc_html( $ct_options['ct_front_submit_min_stay'] ) : '';
$ct_front_submit_check_in = isset( $ct_options['ct_front_submit_check_in'] ) ? esc_html( $ct_options['ct_front_submit_check_in'] ) : '';
$ct_front_submit_check_out = isset( $ct_options['ct_front_submit_check_out'] ) ? esc_html( $ct_options['ct_front_submit_check_out'] ) : '';
$ct_front_submit_extra_person = isset( $ct_options['ct_front_submit_extra_person'] ) ? esc_html( $ct_options['ct_front_submit_extra_person'] ) : '';
$ct_front_submit_cleaning_fee = isset( $ct_options['ct_front_submit_cleaning_fee'] ) ? esc_html( $ct_options['ct_front_submit_cleaning_fee'] ) : '';
$ct_front_submit_cancellation_fee = isset( $ct_options['ct_front_submit_cancellation_fee'] ) ? esc_html( $ct_options['ct_front_submit_cancellation_fee'] ) : '';
$ct_front_submit_security_deposit = isset( $ct_options['ct_front_submit_security_deposit'] ) ? esc_html( $ct_options['ct_front_submit_security_deposit'] ) : '';
$ct_front_submit_address = isset( $ct_options['ct_front_submit_address'] ) ? esc_html( $ct_options['ct_front_submit_address'] ) : '';
$ct_front_submit_city = isset( $ct_options['ct_front_submit_city'] ) ? esc_html( $ct_options['ct_front_submit_city'] ) : '';
$ct_front_submit_state = isset( $ct_options['ct_front_submit_state'] ) ? esc_html( $ct_options['ct_front_submit_state'] ) : '';
$ct_front_submit_zip_post = isset( $ct_options['ct_front_submit_zip_post'] ) ? esc_html( $ct_options['ct_front_submit_zip_post'] ) : '';
$ct_front_submit_county = isset( $ct_options['ct_front_submit_county'] ) ? esc_html( $ct_options['ct_front_submit_county'] ) : '';
$ct_front_submit_country = isset( $ct_options['ct_front_submit_country'] ) ? esc_html( $ct_options['ct_front_submit_country'] ) : '';
$ct_front_submit_community = isset( $ct_options['ct_front_submit_community'] ) ? esc_html( $ct_options['ct_front_submit_community'] ) : '';
$ct_front_submit_lat_long = isset( $ct_options['ct_front_submit_lat_long'] ) ? esc_html( $ct_options['ct_front_submit_lat_long'] ) : '';
$ct_front_submit_private_notes = isset( $ct_options['ct_front_submit_private_notes'] ) ? esc_html( $ct_options['ct_front_submit_private_notes'] ) : '';

global $ct_options;
$view = $ct_options['ct_view'];

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
	

	if(trim($_POST['postTitle']) === '') {
		$postTitleError = 'Please enter an address.';
		$hasError = true;
	} else {
		$postTitle = trim($_POST['postTitle']);
	}

	$post_information = array(
	    'post_title' => wp_strip_all_tags( $_POST['postTitle'] ),
	    'post_content' => $_POST['postContent'],
	    'post_type' => 'listings',
	    'post_status' => $ct_auto_publish
	);

	$post_id = wp_insert_post($post_information);	
	
	/* Files & Documents Uploads */
	$file_ary = array();
	$wordpress_upload_dir = wp_upload_dir();
	$remaining_files = explode(',', $_POST['remaining_files']);
	
	
	if(isset($_FILES['fileUpload'])){
		
		$file_count = count($_FILES['fileUpload']['name']);
		$file_keys = array_keys($_FILES['fileUpload']);
		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $_FILES['fileUpload'][$key][$i];
			}
			
		} 
		
		foreach($file_ary as $file_ary_data){
			$file_name =  $file_ary_data['name'];
			if(in_array($file_name,$remaining_files)){
							
				$file_tmp_name =  $file_ary_data['tmp_name'];
				
				$new_file_mime = @mime_content_type($file_ary_data['tmp_name']);			
                $new_file_path = $wordpress_upload_dir['path'].'/'.$file_name;
                

                                
                /*****************************************************
                 * 
                 * Rename duplicate files with number appended
                 * 
                 ****************************************************/
                if ( file_exists( $new_file_path ) ) {
    
                    $extension = "";
                    $file = $file_name;

                    if ( strstr( $file, "." ) ) {
                        $extension = substr( $file, strrpos( $file, "." ) + 1 );
                        $file = substr( $file, 0, strrpos( $file, "." ) );
    
                        $x = 1;

                        while ( file_exists( $wordpress_upload_dir['path']."/".$file."-".$x.".".$extension ) ) {
                            $x++;
                        }

                        $new_file_path = $wordpress_upload_dir['path']."/".$file."-".$x.".".$extension;

                    }

                }

                
				if (move_uploaded_file($file_tmp_name, $new_file_path)) {
					$upload_id[] = wp_insert_attachment(array(
						'guid' => $new_file_path,
						'post_mime_type' => $new_file_mime,
						'post_title' => preg_replace('/\.[^.]+$/', '', $file_name),
						'post_content' => '',
						'post_status' => 'inherit'
							), $new_file_path);			
					
					require_once( ABSPATH . 'wp-admin/includes/image.php' );
					wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));
				}
			}
		}
		
		/* update post meta and show in backend post */
		if(!empty($upload_id)){
			for($a=0; $a<count($upload_id); $a++){
				$arr[$upload_id[$a]] = wp_get_attachment_url($upload_id[$a]);
			}	
			if(!empty($arr)){
				update_post_meta($post_id, '_ct_files', $arr);
			} 
		}
	}
	
	/* End of files uploads */

    $_POST['att_id'] = isset( $_POST['att_id'] ) ? $_POST['att_id'] : '';
	$slider_img = array();
	if($post_id) {
		foreach($_POST['att_id'] as $img){
			wp_update_post( array( 'ID' => $img,  'post_parent' => $post_id ) );
			$img_url =  wp_get_attachment_url($img);
			$slider_img[$img]=wp_get_attachment_url($img);
		}
		if(!empty($slider_img)){
				update_post_meta($post_id, '_ct_slider', $slider_img);
		} 
				
		$positions=implode(',',$_POST['att_id']);
		update_post_meta($post_id, '_ct_images_position', $positions);

        $ct_price = str_replace(array('.', ','), '' , $_POST['customMetaPrice']);

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($_POST['postTitle'] . ' ' . $_POST['locality'] . ', ' . $_POST['administrative_area_level_1'] . ' ' . $_POST['postal_code']) . '&key=' . $ct_google_maps_api_key;
        $resp = wp_remote_get($url);
        if ( 200 == $resp['response']['code'] ) {
            $body = $resp['body'];
            $data = json_decode($body);
            if($data->status=="OK"){
                $latitude = $data->results[0]->geometry->location->lat;
                $longitude = $data->results[0]->geometry->location->lng;
                update_post_meta($post_id, "_ct_latlng", $latitude.','.$longitude);
                update_post_meta($post_id, "lat", $latitude);
                update_post_meta($post_id, "lng", $longitude);

            }
        }
		
		// Update Custom Meta
		update_post_meta($post_id, '_ct_listing_alt_title', esc_attr(strip_tags($_POST['customMetaAltTitle'])));
        update_post_meta($post_id, '_ct_price', esc_attr(strip_tags($ct_price)));
		update_post_meta($post_id, '_ct_price_prefix', esc_attr(strip_tags($_POST['customMetaPricePrefix'])));
		update_post_meta($post_id, '_ct_price_postfix', esc_attr(strip_tags($_POST['customMetaPricePostfix'])));
		update_post_meta($post_id, '_ct_sqft', esc_attr(strip_tags($_POST['customMetaSqFt'])));
		update_post_meta($post_id, '_ct_lotsize', esc_attr(strip_tags($_POST['customMetaLotSize'])));
		update_post_meta($post_id, '_ct_pets', esc_attr(strip_tags($_POST['customMetaPets'])));
		update_post_meta($post_id, '_ct_parking', esc_attr(strip_tags($_POST['customMetaParking'])));
        update_post_meta($post_id, '_ct_open_house_date', esc_attr(strip_tags($_POST['customMetaOpenHouseDate'])));
        update_post_meta($post_id, '_ct_open_house_start_time', esc_attr(strip_tags($_POST['customMetaOpenHouseStartTime'])));
        update_post_meta($post_id, '_ct_open_house_end_time', esc_attr(strip_tags($_POST['customMetaOpenHouseEndTime'])));
        update_post_meta($post_id, '_ct_video', esc_attr(strip_tags($_POST['customMetaVideoURL'])));
        update_post_meta($post_id, '_ct_virtual_tour_url', $_POST['customMetaVirtualTourURL']);
        update_post_meta($post_id, '_ct_mls', esc_attr(strip_tags($_POST['customMetaMLS'])));
        //update_post_meta($post_id, '_ct_latlng', esc_attr(strip_tags($_POST['customMetaLatLng'])));
        update_post_meta($post_id, '_ct_ownernotes', esc_attr(strip_tags($_POST['customOwnerNotes'])));
        
        if(!empty($ct_listing_expiration)) { 
            update_post_meta($post_id, '_ct_listing_expire', esc_attr(strip_tags($_POST['customMetaExpireListing'])));
        }

        // Rental Information
        $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
        $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
        if($ct_rentals_booking == 'yes' || class_exists('Booking_Calendar') && $ct_submit_rental_info == 'yes') {
            update_post_meta($post_id, '_ct_rental_guests', esc_attr(strip_tags($_POST['customMetaMaxGuests'])));
            update_post_meta($post_id, '_ct_rental_min_stay', esc_attr(strip_tags($_POST['customMetaMinStay'])));
            update_post_meta($post_id, '_ct_rental_checkin', esc_attr(strip_tags($_POST['customMetaCheckIn'])));
            update_post_meta($post_id, '_ct_rental_checkout', esc_attr(strip_tags($_POST['customMetaCheckOut'])));
            update_post_meta($post_id, '_ct_rental_extra_people', esc_attr(strip_tags($_POST['customMetaExtraPerson'])));
            update_post_meta($post_id, '_ct_rental_cleaning', esc_attr(strip_tags($_POST['customMetaCleaningFee'])));
            update_post_meta($post_id, '_ct_rental_cancellation', esc_attr(strip_tags($_POST['customMetaCancellationFee'])));
            update_post_meta($post_id, '_ct_rental_deposit', esc_attr(strip_tags($_POST['customMetaSecurityDeposit'])));
        }

		// Update Custom Taxonomies
		wp_set_post_terms($post_id,array($_POST['ct_property_type']),'property_type',false);
		wp_set_post_terms($post_id,array($_POST['customTaxBeds']),'beds',false);
		wp_set_post_terms($post_id,array($_POST['customTaxBaths']),'baths',false);
		wp_set_post_terms($post_id,array($_POST['ct_status']),'ct_status',true);
		wp_set_post_terms($post_id,array($_POST['ct_featured_status']),'ct_status',true);
		wp_set_post_terms($post_id,array($_POST['locality']),'city',false);
		wp_set_post_terms($post_id,array($_POST['administrative_area_level_1']),'state',false);
		wp_set_post_terms($post_id,array($_POST['postal_code']),'zipcode',false);
        wp_set_post_terms($post_id,array($_POST['county']),'county',false);
        wp_set_post_terms($post_id,array($_POST['country']),'country',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCommunity']),'community',false);
		wp_set_post_terms($post_id,$_POST['customTaxFeat'],'additional_features',false);
		
		// Set Featured Image
		if($_POST['featured_id'] != '') {
			set_post_thumbnail($post_id, $_POST['featured_id']);
		} else {
			set_post_thumbnail($post_id, $_POST['att_id'][0]); 
		}

		// Redirect
		if(is_user_logged_in()){
			$current_user = wp_get_current_user(); 
			$current_user_id = $current_user->ID;
			check_user_package($current_user_id, $view);
		} else {
			wp_redirect( home_url() . '/package-list'); exit;
		} 
	}
}
		 
function check_user_package($userID, $view=''){

	global $ct_options;

	$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';
	$view = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';

	$today = strtotime(date("Y-m-d"));
	$Orders = get_posts(
		array(
			'post_type' => 'package_order',
			'posts_per_page' => 1,
			'author' => $userID,
		)
	);

	foreach($Orders as $post){
		$post_author = $post->post_author;
		$post_id = $post->ID;
		$package_current_date = get_post_meta($post_id,'package_current_date', true);
		$package_expire_date = get_post_meta($post_id,'package_expire_date', true);
	}

	if($ct_enable_front_end_paid == 'yes' && function_exists('ct_create_packages')) {
		if(!empty($package_current_date) && !empty($package_expire_date)){
			$package_current_date = strtotime($package_current_date);
			$package_expire_date = strtotime($package_expire_date);
			if (($today >= $package_current_date)){
				$ct_view_user_listings = home_url('/?page_id=' . $view);
				wp_redirect( $ct_view_user_listings ); exit;
			}
		} else {
			$ct_view_user_listings = home_url('/?page_id=' . $view);
			wp_redirect( $ct_view_user_listings ); exit;
		}
	} else {
		$ct_view_user_listings = home_url('/?page_id=' . $view);
		wp_redirect( $ct_view_user_listings ); exit;
	}
}
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
	// Custom Page Header Background Image
	if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
		echo'<style type="text/css">';
		echo '#single-header { background: url(';
		echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
		echo ') no-repeat center center; background-size: cover;}';
		echo '</style>';
	} ?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
				<?php if(get_post_meta($post->ID, '_ct_page_sub_title', true) != '') { ?>
					<h2 class="marT0 marB0"><?php echo get_post_meta($post->ID, "_ct_page_sub_title", true); ?></h2>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- //Single Header -->
<?php } ?>

<div id="page-content" class="container">

        <?php if(is_user_logged_in()) {
            get_template_part('/includes/user-sidebar');
        } ?>

        <article class="listing col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?> marB60">

        <script>
        jQuery("form input").on("keypress", function(e) {
            return e.keyCode != 13;
        });
        </script>

            <?php if(!is_user_logged_in()) {

            	echo '<div class="must-be-logged-in">';
					echo '<h4 class="center marB20">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
                    echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">Login/Register</a></p>';
                echo '</div>';
                
            } elseif(in_array('administrator', (array) $current_user->roles) || in_array('editor', (array) $current_user->roles) || in_array('author', (array) $current_user->roles) || in_array('contributor', (array) $current_user->roles) || in_array('seller', (array) $current_user->roles) || in_array('agent', (array) $current_user->roles) || in_array('broker', (array) $current_user->roles)) { 

                $item_count = $wpdb->get_var( "SELECT count(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'listings' AND post_author = $userdata->ID" );
                $item_featured_count_query = new WP_Query( array( 'post_type' => 'listings', 'ct_status' => 'featured', 'post_author' => $userdata->ID ) );
                $events = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts WHERE post_author = $userdata->ID AND post_type = 'package_order' order by id" );
            	
            	foreach($events as $data){    
                	$post_id = $data->ID;
                }   
                
                $listing_included = 0;

                if(!empty($post_id)){   
                   $post_meta_id = get_post_meta($post_id,'packageID',true);
                   $post_data = get_post($post_meta_id);
                   $package_id = $post_data->ID;
                   $listing_included = get_post_meta($package_id,'listing',true);
                   $featured_listings_included = get_post_meta($package_id,'featured_listing',true);
                }
                        
                if(function_exists('ct_create_packages') && $item_count == 0 && empty($post_id)) {

                	echo '<div class="col span_12 first packages-notification-large">';
	                    echo '<h4 class="marB20">' . __( 'You haven\'t chosen a package yet…', 'contempo' ) . '</h4>';
	                    echo '<p class="marB0"><a class="btn" href="' . get_page_link($ct_package_list) . '">' . __('Get Started!', 'contempo') . '</a></p>';
	                echo '</div>';

	            } elseif(function_exists('ct_create_packages') && $item_count >= $listing_included) {
                	
                	echo '<div class="col span_12 first packages-notification-large">';
	                    echo '<h4 class="marB5">' . __( 'Listings Limit Reached', 'contempo' ) . '</h4>';
	                    echo '<p class="marB20">' . __('You\'ve reached the listings limit for your membership package.', 'contempo') . '</p>';
	                    echo '<p class="marB0"><a class="btn" href="' . get_page_link($ct_package_list) . '">' . __('Upgrade Today!', 'contempo') . '</a></p>';
	                echo '</div>';
                
                } else { ?>

                    <?php ct_listings_progress_bar(); ?>
            
        			<form action="" id="primaryPostForm" class="front-end-form" method="POST" enctype="multipart/form-data">

                        <?php if ( $postTitleError != '' ) { ?>
                            <span class="error"><?php echo esc_html($postTitleError); ?></span>
                            <div class="clearfix"></div>
                        <?php } ?>

                        <fieldset class="col span_10 first form-section">

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Street Address', 'contempo'); ?></label>
                                <input type="text" name="postTitle" id="postTitle" value="<?php if ( isset( $_POST['postTitle'] ) ) echo esc_attr($_POST['postTitle']); ?>" placeholder="1234 Somewhere St." <?php if($ct_front_submit_street_address == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Alternate Title', 'contempo'); ?></label>
                                <input type="text" name="customMetaAltTitle" id="customMetaAltTitle" value="<?php if ( isset( $_POST['customMetaAltTitle'] ) ) echo esc_attr($_POST['customMetaAltTitle']); ?>" placeholder="<?php esc_html_e('(e.g. Downtown Penthouse)', 'contempo'); ?>" <?php if($ct_front_submit_alt_title == 'required') { echo 'required'; } ?> />
                            </div>

                            	<div class="clear"></div>

                            <div id="property_type" class="col span_4 first">
                                <label><?php esc_html_e('Type', 'contempo'); ?></label>
                                <?php 
	                                $terms = get_terms([
									    'taxonomy' => 'property_type',
									    'hide_empty' => false,
									]);
								?>
                                <select id="ct_property_type" name="ct_property_type" <?php if($ct_front_submit_property_type == 'required') { echo 'required'; } ?>>
									<option value="0"><?php esc_html_e('Any', 'contempo'); ?></option>
									<?php foreach( $terms as $t ) : ?>
										<option value="<?php echo esc_attr($t->term_id); ?>"><?php echo esc_html($t->name); ?></option>
										<?php 
						                    $childterms = get_terms('property_type', array("orderby" => "slug", "parent" => $t->term_id));
						                    if($childterms) :
						                        foreach($childterms as $key => $childterm) :
						                            $childterm_name = str_replace('-', ' ', $childterm->name);
						                            echo '<option value="' . esc_attr($childterm->term_id). '"> — ' . ucwords($childterm_name) . '</option>';
						                        endforeach;
						                    endif;
						                ?>
									<?php endforeach; ?>
								</select>
                            </div>

                            <div id="status" class="col span_4">
                                <label><?php esc_html_e('Status', 'contempo'); ?></label>
                                <?php 
	                                $terms = get_terms([
									    'taxonomy' => 'ct_status',
									    'hide_empty' => false,
									]);
								?>
								<select id="ct_status" name="ct_status" <?php if($ct_front_submit_status == 'required') { echo 'required'; } ?>>
									<option><?php _e('Any', 'contempo'); ?></option>
	                                <?php
	                                	foreach( $terms as $t ) :
		                                $tax_name = str_replace('-', ' ', $t->name);
	                                    $tax_name = strtolower($tax_name);
	                                ?>
										<option value="<?php echo esc_attr($t->slug); ?>"><?php echo ucwords($tax_name); ?></option>
									<?php endforeach; ?>
								</select>
                            </div>

                            <div class="col span_4">
	                            <label><?php esc_html_e('Featured', 'contempo'); ?></label>
	                            <?php if(function_exists('ct_create_packages')) { ?>
	                            	<?php if($item_featured_count_query->found_posts < $featured_listings_included) { ?>
			                            <select id="ct_featured_status" name="ct_featured_status">
											<option value=""><?php _e('No', 'contempo'); ?></option>
											<option value="featured"><?php _e('Yes', 'contempo'); ?></option>
										</select>
									<?php } else { ?>
										<select id="ct_featured_status" name="ct_featured_status" disabled="">
											<option value=""><?php if($featured_listings_included == 0) { _e('Not Included', 'contempo'); } elseif($featured_listings_included >= 1) { _e('Package Limit Reached', 'contempo'); } ?></option>
										</select>
									<?php } ?>
								<?php } else { ?>
									<select id="ct_featured_status" name="ct_featured_status">
										<option value=""><?php _e('No', 'contempo'); ?></option>
										<option value="featured"><?php _e('Yes', 'contempo'); ?></option>
									</select>
								<?php } ?>
                            </div>

	                            <div class="clear"></div>

                            <div class="col span_4 first marT15">
                                <label><?php esc_html_e('Price', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="number" name="customMetaPrice" id="customMetaPrice" value="<?php if(isset($_POST['customMetaPrice'])) echo esc_attr($_POST['customMetaPrice']);?>" <?php if($ct_front_submit_price == 'required') { echo 'required'; } ?> />
                            </div> 

                            <div class="col span_4 marT15">
                                <label><?php esc_html_e('Price Prefix', 'contempo'); ?></label>
                                <input type="text" name="customMetaPricePrefix" id="customMetaPricePrefix" placeholder="<?php esc_html_e(' (e.g. From, Call for price)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaPricePrefix'])) echo esc_attr($_POST['customMetaPricePrefix']);?>" <?php if($ct_front_submit_price_prefix == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4 marT15">
                                <label><?php esc_html_e('Price Postfix Text', 'contempo'); ?></label>
                                <input type="text" name="customMetaPricePostfix" id="customMetaPricePostfix" placeholder="<?php esc_html_e(' (e.g. /month, /week)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaPricePostfix'])) echo esc_attr($_POST['customMetaPricePostfix']);?>" <?php if($ct_front_submit_price_postfix == 'required') { echo 'required'; } ?> />
                            </div>

                                <div class="clear"></div>

                            <label><?php esc_html_e('Listing Description', 'contempo'); ?></label>
                            <?php
                                $content = '';
                                $editor_id = 'postContent';

                                wp_editor( $content, $editor_id, $settings = array('textarea_rows' => '8') );
                            ?>

                        </fieldset>

                        <fieldset class="col span_10 first form-section">

                            <div style="display: none;">
                                <div class="left">
                                    <label><?php esc_html_e('Listing Featured Image', 'contempo'); ?></label>
                                    <input type="file" name="featuredImage" id="featuredImage" />
                                </div>

                                <div class="left">
                                    <label><?php esc_html_e('Gallery Images (select as many as you like)', 'contempo'); ?></label>
                                    <input type="file" name="galleryImages" id="galleryImages" multiple="" />
                                </div>
                            </div>

                            <div class="1-left">
                                <div class="col span_12 first">
                                    <label><?php esc_html_e('Listing Images', 'contempo'); ?></label>
                                    <input type="hidden" id="featured_id" name="featured_id" value="" />
                                    <ul class="marT15 listing-images ui-sortable" id="sortable">
                                        
                                    </ul>
                                    <div id="plupload-upload-ui" class="hide-if-no-js drag-drop"> <!-- RF -->                           
                                    <div class="drag-drop col span_12 first row">
                                        <div id="drag-drop-area" class="drag-drop-area">
                                            <div class="drag-drop-msg">
                                                <i class="fa fa-cloud-upload"></i><br />
                                                <strong><?php esc_html_e('Drag & Drop Images Here', 'contempo'); ?></strong>
                                            </div>
                                            <div class="drag-drop-or">
                                                <?php esc_html_e('or', 'contempo'); ?>
                                            </div>
                                            <div class="drag-drop-btn">
                                                <a id="select-images" class="btn" href="javascript:;"><?php esc_html_e('Select Images', 'contempo'); ?></a>
                                            </div>
                                        </div>
                                        <input style="display: none;" type="file" name="galleryImages" id="galleryImages" multiple="" />
                                        <p class="muted marT10 marB0"><?php esc_html_e('*At least one image is for valid submission, minimum width of 817px.', 'contempo'); ?></p>
                                        <p class="muted marB0"><?php esc_html_e('*You can mark an image as featured by clicking the star icon, Otherwise first image will be considered featured image.', 'contempo'); ?></p>
                                        <div id="plupload-container"></div>
                                        <div id="errors-log"></div>
                                    </div>
                                    </div> <!-- RF --> 
                                </div>
                            </div>
							
							<div class="1-left">
								<div id="files-documents" class="col span_12 first">
                                    <label class="left"><?php esc_html_e('Files & Documents', 'contempo'); ?></label>
									<input type="button" id="select-file" class="btn right" value="Add or Upload Files" />
										<div class="clear"></div>
									<input type="file" name="fileUpload[]" id="fileUpload" multiple="" onchange="readURL(this);" style="display:none;"/>
									
									<input type="hidden" id="remaining_files" value="" name="remaining_files" />
									
									<div id="fileList">
										<ul class="files-content">
										</ul>
									</div>

									<p class="muted marB0 small"><?php esc_html_e('*Supported file types are PDF, Word, Excel & PowerPoint.', 'contempo'); ?></p>
								</div>
							</div>
                        </fieldset>

						<script>
							//fileupload	
							jQuery("#select-file").click(function(){
								 jQuery('#fileUpload').click();
							})
							function readURL(input) {
							var input = document.getElementById('fileUpload');
							var output = document.getElementById('fileList');
							var url = input.value;
							var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
						
								if (input.files && input.files[0]&& (ext == "pdf" || ext == "docx" || ext == "doc" ||ext == "ppt" || ext == "pptx" || ext == "xlsx" || ext == "xls" || ext == "csv")) {
									for (var i = 0; i < input.files.length; ++i) {
										jQuery('.files-content').append('<li class="files-name clr"><div class="files-text left">' + input.files.item(i).name +'<span class="file-sepration">,</span></div><div class="filedelete-img right btn"><i class="fa fa-trash-o"></i></div></li>');
										
										//append all files name
										var text = jQuery(".files-text").text(); 
										jQuery("#remaining_files").val(text);
											//alert(text);
									
										jQuery(".filedelete-img").on('click', function() { 					
											jQuery(this).parent().remove();	
											//append remaing files name after remove
											var text = jQuery(".files-text").text(); 
											jQuery("#remaining_files").val(text);					
										});
									}
								}								
							}							
						</script>
						
                        <fieldset class="col span_10 first form-section">

                            <div class="col span_4 first">
                            	<label><?php ct_bed_beds_or_bedrooms(); ?></label>
                                <input type="number" name="customTaxBeds" id="customTaxBeds" value="<?php if(isset($_POST['customTaxBeds'])) echo esc_attr($_POST['customTaxBeds']);?>" <?php if($ct_front_submit_beds == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                            	<label><?php ct_bath_baths_or_bathrooms(); ?></label>
                                <input type="number" name="customTaxBaths" id="customTaxBaths" value="<?php if(isset($_POST['customTaxBaths'])) echo esc_attr($_POST['customTaxBaths']);?>" <?php if($ct_front_submit_baths == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                                <label><?php echo strtoupper(ct_sqftsqm()); ?></label>
                                <input type="number" name="customMetaSqFt" id="customMetaSqFt" value="<?php if(isset($_POST['customMetaSqFt'])) echo esc_attr($_POST['customMetaSqFt']);?>" <?php if($ct_front_submit_size == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4 first">
                                <label><?php esc_html_e('Lot Size', 'contempo'); ?></label>
                                <input type="number" name="customMetaLotSize" id="customMetaLotSize" value="<?php if(isset($_POST['customMetaLotSize'])) echo esc_attr($_POST['customMetaLotSize']);?>" <?php if($ct_front_submit_lot_size == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                                <label><?php esc_html_e('Pets', 'contempo'); ?></label>
                                <input type="text" name="customMetaPets" id="customMetaPets" value="<?php if(isset($_POST['customMetaPets'])) echo esc_attr($_POST['customMetaPets']);?>" placeholder="<?php _e('(e.g. Cats, small dogs)', 'contempo'); ?>" <?php if($ct_front_submit_pets == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                                <label><?php esc_html_e('Parking', 'contempo'); ?></label>
                                <input type="text" name="customMetaParking" id="customMetaParking" value="<?php if(isset($_POST['customMetaParking'])) echo esc_attr($_POST['customMetaParking']);?>" placeholder="<?php _e('(e.g. Carport, 2 Car Garage)', 'contempo'); ?>" <?php if($ct_front_submit_parking == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Property ID', 'contempo'); ?></label>
                                <input type="text" name="customMetaMLS" id="customMetaMLS" value="<?php if(isset($_POST['customMetaMLS'])) echo esc_attr($_POST['customMetaMLS']);?> <?php if($ct_generate_listing_id == 'yes') {ct_generate_listing_id(); } ?>" <?php if($ct_front_submit_property_id == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Video URL', 'contempo'); ?></label>
                                <input type="text" name="customMetaVideoURL" id="customMetaVideoURL" value="<?php if(isset($_POST['customMetaVideoURL'])) echo esc_attr($_POST['customMetaVideoURL']);?>" <?php if($ct_front_submit_video_url == 'required') { echo 'required'; } ?> />
                            </div>

                                <div class="clear"></div>

                            <div class="col span_12 first">
                                <label><?php esc_html_e('Virtual Tour URL', 'contempo'); ?></label>
                                <input type="text" name="customMetaVirtualTourURL" id="customMetaVirtualTourURL" value="<?php if(isset($_POST['customMetaVirtualTourURL'])) echo esc_attr($_POST['customMetaVirtualTourURL']);?>" <?php if($ct_front_submit_virtual_tour == 'required') { echo 'required'; } ?> />
                            </div>

                            	<div class="clear"></div>

                            <div id="listing-open-house">

                                <h5 class="marT0 border-bottom"><?php _e('Open House', 'contempo'); ?></h5>

                                <div class="col span_4 first">
                                    <label><?php esc_html_e('Date', 'contempo'); ?></label>
                                    <input type="text" name="customMetaOpenHouseDate" id="customMetaOpenHouseDate" value="<?php if(isset($_POST['customMetaOpenHouseDate'])) echo esc_attr($_POST['customMetaOpenHouseDate']);?>" <?php if($ct_front_submit_open_house_date == 'required') { echo 'required'; } ?> />
                                </div>

                                <div class="col span_4">
                                    <label><?php esc_html_e('Start Time', 'contempo'); ?></label>
                                    <input type="text" name="customMetaOpenHouseStartTime" id="customMetaOpenHouseStartTime" value="<?php if(isset($_POST['customMetaOpenHouseStartTime'])) echo esc_attr($_POST['customMetaOpenHouseStartTime']);?>" <?php if($ct_front_submit_open_house_start_time == 'required') { echo 'required'; } ?> />
                                </div>

                                <div class="col span_4">
                                    <label><?php esc_html_e('End Time', 'contempo'); ?></label>
                                    <input type="text" name="customMetaOpenHouseEndTime" id="customMetaOpenHouseEndTime" value="<?php if(isset($_POST['customMetaOpenHouseEndTime'])) echo esc_attr($_POST['customMetaOpenHouseEndTime']);?>" <?php if($ct_front_submit_open_house_end_time == 'required') { echo 'required'; } ?> />
                                </div>

                                    <div class="clear"></div>

                            </div>

                            <?php function ct_post_additional_features() {
                            	if(isset( $_POST['customTaxFeat'])) {
                                    if(function_exists('stripslashes')) {
                                        echo stripslashes( $_POST['customTaxFeat'] );
                                    } else {
                                        echo esc_html($_POST['customTaxFeat']);
                                    }
                                }
                            } ?>

                            <label><?php esc_html_e('Additional Features (comma separated)', 'contempo'); ?></label>
                            <textarea name="customTaxFeat" id="customTaxFeat" rows="8" cols="30" placeholder="Pool, Spa, Gated Community" <?php if($ct_front_submit_additional_features == 'required') { echo 'required'; } ?>><?php ct_post_additional_features(); ?></textarea>

                        </fieldset>

                        <?php

                        $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
                        $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
                        
                        if($ct_rentals_booking == 'yes' || class_exists('Booking_Calendar') && $ct_submit_rental_info == 'yes') { ?>

                            <fieldset class="col span_10 first form-section">

                                <div class="col span_6 first">
                                    <label><?php esc_html_e('Max-number of Guests', 'contempo'); ?></label>
                                    <input type="number" name="customMetaMaxGuests" id="customMetaMaxGuests" placeholder="<?php esc_html_e(' (e.g. 2)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaMaxGuests'])) echo esc_attr($_POST['customMetaMaxGuests']);?>" <?php if($ct_front_submit_max_guests == 'required') { echo 'required'; } ?> />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Minimum Stay', 'contempo'); ?></label>
                                    <input type="number" name="customMetaMinStay" id="customMetaMinStay" placeholder="<?php esc_html_e(' (e.g. 1 night)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaMinStay'])) echo esc_attr($_POST['customMetaMinStay']);?>" <?php if($ct_front_submit_min_stay == 'required') { echo 'required'; } ?> />
                                </div>

                                    <div class="clear"></div>

                                <div class="col span_6 first">
                                    <label><?php esc_html_e('Check In Time', 'contempo'); ?></label>
                                    <input type="number" name="customMetaCheckIn" id="customMetaCheckIn" placeholder="<?php esc_html_e(' (e.g. 3:00 PM)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCheckIn'])) echo esc_attr($_POST['customMetaCheckIn']);?>" <?php if($ct_front_submit_check_in == 'required') { echo 'required'; } ?> />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Check Out Time', 'contempo'); ?></label>
                                    <input type="number" name="customMetaCheckOut" id="customMetaCheckOut" placeholder="<?php esc_html_e(' (e.g. 11:00 AM)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCheckOut'])) echo esc_attr($_POST['customMetaCheckOut']);?>" <?php if($ct_front_submit_check_out == 'required') { echo 'required'; } ?> />
                                </div>

                                    <div class="clear"></div>

                                <div class="col span_6 first">
                                    <label><?php esc_html_e('Extra Person Charge', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="number" name="customMetaExtraPerson" id="customMetaExtraPerson" placeholder="<?php esc_html_e(' (e.g. 50)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaExtraPerson'])) echo esc_attr($_POST['customMetaExtraPerson']);?>" <?php if($ct_front_submit_extra_person == 'required') { echo 'required'; } ?> />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Cleaning Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="number" name="customMetaCleaningFee" id="customMetaCleaningFee" placeholder="<?php esc_html_e(' (e.g. 150)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCleaningFee'])) echo esc_attr($_POST['customMetaCleaningFee']);?>" <?php if($ct_front_submit_cleaning_fee == 'required') { echo 'required'; } ?> />
                                </div>

                                    <div class="clear"></div>

                                <div class="col span_6 first">
                                    <label><?php esc_html_e('Cancellation Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="number" name="customMetaCancellationFee" id="customMetaCancellationFee" placeholder="<?php esc_html_e(' (e.g. 275)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCancellationFee'])) echo esc_attr($_POST['customMetaCancellationFee']);?>" <?php if($ct_front_submit_cancellation_fee == 'required') { echo 'required'; } ?> />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Security Deposit', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="number" name="customMetaSecurityDeposit" id="customMetaSecurityDeposit" placeholder="<?php esc_html_e(' (e.g. 895)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaSecurityDeposit'])) echo esc_attr($_POST['customMetaSecurityDeposit']);?>" <?php if($ct_front_submit_security_deposit == 'required') { echo 'required'; } ?> />
                                </div>

                                    <div class="clear"></div>

                            </fieldset>
                        <?php } ?>

                        <fieldset class="col span_10 first form-section">

                            <div class="input-full-width">
                                <label><?php esc_html_e('Address', 'contempo'); ?></label>
                                <input type="text" name="pac-input" id="pac-input" value="" placeholder="<?php _e('Type in an address', 'contempo'); ?>" <?php if($ct_front_submit_address == 'required') { echo 'required'; } ?> />
                                <div id="autocomplete-results"></div>
                            </div>

                            <div class="col span_4 first">
                            	<label><?php ct_city_town_or_village(); ?></label>
                                <input type="text" name="locality" id="customTaxCity" value="<?php if ( isset( $_POST['customTaxCity'] ) ) echo esc_attr($_POST['customTaxCity']); ?>"  <?php if($ct_front_submit_city == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                                <label><?php ct_state_or_area(); ?></label>
                                <input type="text" name="administrative_area_level_1" id="customTaxState" value="<?php if ( isset( $_POST['customTaxState'] ) ) echo esc_attr($_POST['customTaxState']); ?>"  <?php if($ct_front_submit_state == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                                <label><?php ct_zip_or_post(); ?></label>
                                <input type="text" name="postal_code" id="customTaxZip" value="<?php if ( isset( $_POST['customTaxZip'] ) ) echo esc_attr($_POST['customTaxZip']); ?>"  <?php if($ct_front_submit_zip_post == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4 first">
                                <label><?php esc_html_e('County', 'contempo'); ?></label>
                                <input type="text" name="county" id="county" value="<?php if ( isset( $_POST['county'] ) ) echo esc_attr($_POST['county']); ?>"  <?php if($ct_front_submit_county == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                                <label><?php esc_html_e('Country', 'contempo'); ?></label>
                                <input type="text" name="country" id="customTaxCountry" value="<?php if ( isset( $_POST['customTaxCountry'] ) ) echo esc_attr($_POST['customTaxCountry']); ?>"  <?php if($ct_front_submit_country == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_4">
                                <label><?php ct_community_neighborhood_or_district(); ?></label>
                                <input type="text" name="customTaxCommunity" id="customTaxCommunity" value="<?php if ( isset( $_POST['customTaxCommunity'] ) ) echo esc_attr($_POST['customTaxCommunity']); ?>" <?php if($ct_front_submit_community == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_12 first">
                                <input type="text" name="customMetaLatLng" id="customMetaLatLng" placeholder="<?php esc_html_e('Latitude & Longitude (optional)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaLatLng'])) echo esc_attr($_POST['customMetaLatLng']);?>" <?php if($ct_front_submit_lat_long == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_12 first">
                                <div id="map-canvas"></div>
                            </div>

                                <div class="clear"></div>

                            <p class="form-note"><?php _e('You can also manually drag the marker to the exact location of your listing if the automatic geolocation is off.', 'contempo'); ?></p>

                        </fieldset>

                        <fieldset class="col span_10 first form-section">

                        	<?php function ct_post_private_notes() {
                        		if (isset( $_POST['customOwnerNotes'])) {
                                    echo esc_html($_POST['customOwnerNotes']);
                                }
                            } ?>

                            <label><?php esc_html_e('Private Notes', 'contempo'); ?></label>
                            <textarea name="customOwnerNotes" id="customOwnerNotes" rows="8" cols="30" placeholder="<?php _e('Write a private note about this listing, this textarea will not be displayed anywhere on the front end of the site.', 'contempo'); ?>" <?php if($ct_front_submit_private_notes == 'required') { echo 'required'; } ?>><?php ct_post_private_notes(); ?></textarea>

                        </fieldset>

                        <script>
                            jQuery(document).ready(function(){
                                jQuery(".previous").on("click", function() {
                                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                                    return false;
                                });
                                jQuery(".next").on("click", function() {
                                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                                    return false;
                                });
                            });
                        </script>

                        <div class="col span_12 first fieldset-buttons">
                            <div class="col span_9 first">
                                <a class="btn btn-cancel left" href="<?php echo get_page_link($user_listings); ?>" data-tooltip="<?php _e('Cancel', 'contempo'); ?>"><i class="fa fa-close"></i></a>
                                <input class="btn save-draft btn-secondary left" href="#" type="submit" value="<?php esc_html_e('Save As Draft', 'contempo'); ?> " name="draft" style="display:block !important"/>
                            </div>
							<div style="display: none;">
								<input name="lat" type="text" value="">
								<input name="lng" type="text" value="">
								<input name="formatted_address" type="text" value="">
							</div>
                            <div class="col span_3">
                                <a name="next" class="next btn right" data-tooltip="<?php _e('Next', 'contempo'); ?>"><i class="fas fa-chevron-right"></i></a>
                                <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>

                                <?php if(!empty($ct_listing_expiration)) { ?>
                                <input type="hidden" name="customMetaExpireListing" id="customMetaExpireListing" value="<?php echo esc_attr($ct_listing_expiration); ?>" id="submit_old"/>
                                <?php } ?>

                                <input type="hidden" name="submitted" id="submitted" value="true" />
                                <input type="submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" tabindex="5" id="submit" name="submit" class="btn right" onClick="javascript:jQuery('#primaryPostForm').parsley( 'validate' );" />
                                <a name="previous" class="previous btn right" data-tooltip="<?php _e('Previous', 'contempo'); ?>"><i class="fas fa-chevron-left"></i></a>
                            </button>
                        </div>

                    </form>

                <?php } ?>

            <?php } ?>
            
            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
            
            <?php endwhile; endif; wp_reset_query(); ?>
            
                <div class="clear"></div>

        </article>
		
			<?php echo '<div class="clear"></div>';

echo '</div>';

get_footer(); ?>
