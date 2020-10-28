<?php

/**
 * Custom Fields
 *
 * @link       http://contempographicdesign.com
 * @since      1.0.0
 *
 * @package    Contempo Real Estate Custom Posts
 * @subpackage ct-real-estate-custom-posts/includes
 */

// Include & setup custom metabox and fields
$prefix = '_ct_'; // start with an underscore to hide fields from custom fields list
add_filter( 'cmb_meta_boxes', 'ct_real_estate_metaboxes' );
function ct_real_estate_metaboxes( $meta_boxes ) {
	global $prefix;

	$meta_boxes[] = array(
		'id' => 'post_options_metabox',
		'title' => __('Post Options', 'contempo'),
		'pages' => array('post','galleries'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Header', 'contempo'),
				'desc' => __('Display Post Header?', 'contempo'),
				'id' => $prefix . 'post_header',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
			array(
				'name' => __('Title', 'contempo'),
				'desc' => __('Display Post Title?', 'contempo'),
				'id' => $prefix . 'post_title',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
			array(
				'name' => __('Sub Title', 'contempo'),
				'desc' => __('Enter the sub title here, if you\'d like to use one.', 'contempo'),
				'id' => $prefix . 'sub_title',
				'type' => 'text'
			),
			array(
				'name' => __('Post Header Background Image', 'contempo'),
				'desc' => __('Use Featured Image as Header Background?', 'contempo'),
				'id' => $prefix . 'post_header_bg',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
			array(
			    'name' => __('Post Header Background Color', 'contempo'),
			    'desc' => __('If you don\'t have a featured post image, you can specify a custom bg color for your header here.)', 'contempo'),
			    'id'   => $prefix . '_post_header_bg_color',
			    'type' => 'colorpicker',
			    'default'  => '',
			    'repeatable' => false,
			),
			array(
				'name' => __('Automatic Slider', 'contempo'),
				'desc' => __('Display automatic slider if more than one image is uploaded to a post on archive &amp; category pages?', 'contempo'),
				'id' => $prefix . 'post_slider',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
			array(
				'name' => __('Video', 'contempo'),
				'desc' => __('Enter the sub title here, if you\'d like to use one.', 'contempo'),
				'id' => $prefix . 'ct_video',
				'type' => 'textarea'
			),
		)
	);

	global $ct_options;
	$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';

    if($ct_rentals_booking == 'yes') {
		$meta_boxes[] = array(
			'id' => 'rental_metabox',
			'title' => __('Rental Info', 'contempo'),
			'pages' => array('listings'), // post type
			'context' => 'normal',
			'priority' => 'default',
			'show_names' => false, // Show field names on the left
			'fields' => array(
				array(
					'name' => __('Booking Calendar Shortcode', 'contempo'),
					'desc' => __('Paste your booking calendar shortcode here, e.g. [booking nummonths=1].', 'contempo'),
					'id' => $prefix . 'booking_cal_shortcode',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Listing Title', 'contempo'),
					'desc' => __('Enter the listing title here, e.g. Villa in Bali.', 'contempo'),
					'id' => $prefix . 'rental_title',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Guests', 'contempo'),
					'desc' => __('Enter the max-number of guests here, e.g. 2.', 'contempo'),
					'id' => $prefix . 'rental_guests',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Availability', 'contempo'),
					'desc' => __('Enter minimum stay, e.g. 1 night.', 'contempo'),
					'id' => $prefix . 'rental_min_stay',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Check In Time', 'contempo'),
					'desc' => __('Enter check in time.', 'contempo'),
					'id' => $prefix . 'rental_checkin',
					'type' => 'text_time'
				),
				array(
					'name' => __('Check Out Time', 'contempo'),
					'desc' => __('Enter check out time.', 'contempo'),
					'id' => $prefix . 'rental_checkout',
					'type' => 'text_time'
				),
				array(
					'name' => __('Extra People Charge', 'contempo'),
					'desc' => __('Enter extra per person charge, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_extra_people',
					'type' => 'text_money'
				),
				array(
					'name' => __('Cleaning Fee', 'contempo'),
					'desc' => __('Enter cleaning fee, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_cleaning',
					'type' => 'text_money'
				),
				array(
					'name' => __('Cancellation Fee', 'contempo'),
					'desc' => __('Enter cancellation fee, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_cancellation',
					'type' => 'text_money'
				),
				array(
					'name' => __('Security Deposit', 'contempo'),
					'desc' => __('Enter the security deposit, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_deposit',
					'type' => 'text_money'
				),
			)
		);
	}

	$meta_boxes[] = array(
		'id' => 'page_metabox',
		'title' => __('Page Options', 'contempo'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
            array(
                'name' => __('Display Page Title?', 'contempo'),
                'desc' => __('Select whether or not you\'d like to display the page title?', 'contempo'),
                'id' => $prefix . 'inner_page_title',
                'type' => 'select',
                'options' => array(
                    array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),	               
                )
            ),
            array(
                'name' => __('Sub Title', 'contempo'),
                'desc' => __('Enter the sub title here, if you\'d like to use one.', 'contempo'),
                'id' => $prefix . 'page_sub_title',
                'type' => 'text'
            ),
            array(
                'name' => __('Page Header Background Image', 'contempo'),
                'desc' => __('Add a background image for your page header.', 'contempo'),
                'id' => $prefix . 'page_header_bg_image',
                'type' => 'file'
            ),
            array(
                'name' => __('Top Page Margin?', 'contempo'),
                'desc' => __('Select whether or not you\'d like the top page margin to seperate the header and content area?', 'contempo'),
                'id' => $prefix . 'top_page_margin',
                'type' => 'select',
                'options' => array(
                    array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),	               
                )
            ),
            array(
                'name' => __('Bottom Page Margin?', 'contempo'),
                'desc' => __('Select whether or not you\'d like the top page margin to seperate the content area and footer?', 'contempo'),
                'id' => $prefix . 'bottom_page_margin',
                'type' => 'select',
                'options' => array(
                    array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),	               
                )
            ),
		)
	);

	global $ct_options;
	$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';

	if($ct_enable_front_end_paid == 'yes') {
		$meta_boxes[] = array(
			'id' => 'listing_paid_submission_info',
			'title' => __('Paid Submission Information', 'contempo'),
			'pages' => array('listings'), // post type
			'context' => 'normal',
			'priority' => 'default',
			'show_names' => false, // Show field names on the left
			'fields' => array(
				array(
						'name' => __('Transaction ID', 'contempo'),
						'desc' => __('Transaction ID', 'contempo'),
						'id' => $prefix . 'listing_paid_transaction_id',
						'type' => 'text_medium'
				),
			)
		);
	}
	
	return $meta_boxes;
}

// Initialize the metabox class
add_action( 'init', 'ct_real_estate_initialize_cmb_meta_boxes', 9999 );
function ct_real_estate_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once (plugin_dir_path( __FILE__ ) . 'init.php');
	}
}