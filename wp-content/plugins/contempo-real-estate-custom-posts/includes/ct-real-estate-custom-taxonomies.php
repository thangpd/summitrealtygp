<?php

/**
 * Register Custom Taxonmoies
 * Text Domain:       contempo
 * Domain Path:       /languages
 *
 * @link       http://contempographicdesign.com
 * @since      1.0.0
 *
 * @package    Contempo Real Estate Custom Posts
 * @subpackage contempo-real-estate-custom-posts/includes
 */

global $ct_options;

if ( ! function_exists( 'ct_realestate_taxonomies' ) ) {

	/**
	 * Register Custom Taxonomies
	 *
	 */

	add_action( 'init', 'ct_realestate_taxonomies', 0 );

	function ct_realestate_taxonomies() {

		global $ct_options;

		function ct_taxonomy($name){
			global $post;
			global $wp_query;
			$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, $name, '', ', ', '' ) );
			if($terms_as_text != '') {
				echo esc_html($terms_as_text);
			}
		}

		// Property Type
		$ptlabels = array(
			'name' => __( 'Property Type', 'contempo' ),
			'singular_name' => __( 'Property Type', 'contempo' ),
			'search_items' =>  __( 'Search Property Types', 'contempo' ),
			'popular_items' => __( 'Popular Property Types', 'contempo' ),
			'all_items' => __( 'All Property Types', 'contempo' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Property Type', 'contempo' ),
			'update_item' => __( 'Update Property Type', 'contempo' ),
			'add_new_item' => __( 'Add New Property Type', 'contempo' ),
			'new_item_name' => __( 'New Property Type Name', 'contempo' ),
			'separate_items_with_commas' => __( 'Separate Property Types with commas', 'contempo' ),
			'add_or_remove_items' => __( 'Add or remove Property Types', 'contempo' ),
			'choose_from_most_used' => __( 'Choose from the most used Property Types', 'contempo' )
		);
		register_taxonomy( 'property_type', 'listings', array(
			'hierarchical' => true,
			'labels' => $ptlabels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'property-type' ),
		));

		if ( ! function_exists( 'propertytype' ) ) {
			function propertytype() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'property_type', '', ', ', '' ) );
				echo esc_html($terms_as_text);
			}
		}

		$ct_bed_beds_or_bedrooms = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? $ct_options['ct_bed_beds_or_bedrooms'] : '';

		if($ct_bed_beds_or_bedrooms == 'rooms') {
			// Rooms
			$bedslabels = array(
				'name' => __( 'Rooms', 'contempo' ),
				'singular_name' => __( 'Room', 'contempo' ),
				'search_items' =>  __( 'Search Rooms', 'contempo' ),
				'popular_items' => __( 'Popular Rooms', 'contempo' ),
				'all_items' => __( 'All Rooms', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Rooms', 'contempo' ),
				'update_item' => __( 'Update Rooms', 'contempo' ),
				'add_new_item' => __( 'Add New Rooms', 'contempo' ),
				'new_item_name' => __( 'New Rooms Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Rooms with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Rooms', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Rooms', 'contempo' )
			);
			register_taxonomy( 'beds', 'listings', array(
				'hierarchical' => false,
				'labels' => $bedslabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'rooms' ),
			));
		} elseif($ct_bed_beds_or_bedrooms == 'bedrooms') {
			// Bedroom
			$bedslabels = array(
				'name' => __( 'Bedrooms', 'contempo' ),
				'singular_name' => __( 'Bedroom', 'contempo' ),
				'search_items' =>  __( 'Search Bedrooms', 'contempo' ),
				'popular_items' => __( 'Popular Bedrooms', 'contempo' ),
				'all_items' => __( 'All Bedrooms', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Bedrooms', 'contempo' ),
				'update_item' => __( 'Update Bedrooms', 'contempo' ),
				'add_new_item' => __( 'Add New Bedrooms', 'contempo' ),
				'new_item_name' => __( 'New Bedrooms Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Bedrooms with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Bedrooms', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Bedrooms', 'contempo' )
			);
			register_taxonomy( 'beds', 'listings', array(
				'hierarchical' => false,
				'labels' => $bedslabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'bedroom' ),
			));
		} elseif($ct_bed_beds_or_bedrooms == 'beds') {
			// Beds
			$bedslabels = array(
				'name' => __( 'Beds', 'contempo' ),
				'singular_name' => __( 'Beds', 'contempo' ),
				'search_items' =>  __( 'Search Beds', 'contempo' ),
				'popular_items' => __( 'Popular Beds', 'contempo' ),
				'all_items' => __( 'All Beds', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Beds', 'contempo' ),
				'update_item' => __( 'Update Beds', 'contempo' ),
				'add_new_item' => __( 'Add New Beds', 'contempo' ),
				'new_item_name' => __( 'New Beds Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Beds with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Beds', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Beds', 'contempo' )
			);
			register_taxonomy( 'beds', 'listings', array(
				'hierarchical' => false,
				'labels' => $bedslabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'beds' ),
			));
		} else {
			// Bed
			$bedslabels = array(
				'name' => __( 'Bed', 'contempo' ),
				'singular_name' => __( 'Bed', 'contempo' ),
				'search_items' =>  __( 'Search Beds', 'contempo' ),
				'popular_items' => __( 'Popular Beds', 'contempo' ),
				'all_items' => __( 'All Beds', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Beds', 'contempo' ),
				'update_item' => __( 'Update Beds', 'contempo' ),
				'add_new_item' => __( 'Add New Beds', 'contempo' ),
				'new_item_name' => __( 'New Beds Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Beds with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Beds', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Beds', 'contempo' )
			);
			register_taxonomy( 'beds', 'listings', array(
				'hierarchical' => false,
				'labels' => $bedslabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'bed' ),
			));
		}

		if ( ! function_exists( 'beds' ) ) {
			function beds() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
				if($terms_as_text != '') {
					echo esc_html($terms_as_text);
				}
			}
		}

		$ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? $ct_options['ct_bath_baths_or_bathrooms'] : '';

		if($ct_bath_baths_or_bathrooms == 'bathrooms') {
			// Bathrooms
			$bathslabels = array(
				'name' => __( 'Bathrooms', 'contempo' ),
				'singular_name' => __( 'Bathroom', 'contempo' ),
				'search_items' =>  __( 'Search Bathrooms', 'contempo' ),
				'popular_items' => __( 'Popular Bathrooms', 'contempo' ),
				'all_items' => __( 'All Bathrooms', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Bathrooms', 'contempo' ),
				'update_item' => __( 'Update Bathrooms', 'contempo' ),
				'add_new_item' => __( 'Add New Bathrooms', 'contempo' ),
				'new_item_name' => __( 'New Bathrooms Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Bathrooms with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Bathrooms', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Bathrooms', 'contempo' )
			);
			register_taxonomy( 'baths', 'listings', array(
				'hierarchical' => false,
				'labels' => $bathslabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'bath' ),
			));
		} elseif($ct_bath_baths_or_bathrooms == 'bath') {
			// Bath
			$bathslabels = array(
				'name' => __( 'Bath', 'contempo' ),
				'singular_name' => __( 'Bath', 'contempo' ),
				'search_items' =>  __( 'Search Baths', 'contempo' ),
				'popular_items' => __( 'Popular Baths', 'contempo' ),
				'all_items' => __( 'All Baths', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Baths', 'contempo' ),
				'update_item' => __( 'Update Baths', 'contempo' ),
				'add_new_item' => __( 'Add New Baths', 'contempo' ),
				'new_item_name' => __( 'New Baths Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Baths with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Baths', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Baths', 'contempo' )
			);
			register_taxonomy( 'baths', 'listings', array(
				'hierarchical' => false,
				'labels' => $bathslabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'bath' ),
			));
		} else {
			// Baths
			$bathslabels = array(
				'name' => __( 'Baths', 'contempo' ),
				'singular_name' => __( 'Baths', 'contempo' ),
				'search_items' =>  __( 'Search Baths', 'contempo' ),
				'popular_items' => __( 'Popular Baths', 'contempo' ),
				'all_items' => __( 'All Baths', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Baths', 'contempo' ),
				'update_item' => __( 'Update Baths', 'contempo' ),
				'add_new_item' => __( 'Add New Baths', 'contempo' ),
				'new_item_name' => __( 'New Baths Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Baths with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Baths', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Baths', 'contempo' )
			);
			register_taxonomy( 'baths', 'listings', array(
				'hierarchical' => false,
				'labels' => $bathslabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'baths' ),
			));
		}

		if ( ! function_exists( 'baths' ) ) {
			function baths() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );
				if($terms_as_text != '') {
					echo esc_html($terms_as_text);
				}
			}
		}

		// Status
		$statuslabels = array(
			'name' => __( 'Status', 'contempo' ),
			'singular_name' => __( 'Status', 'contempo' ),
			'search_items' =>  __( 'Search Statuses', 'contempo' ),
			'popular_items' => __( 'Popular Statuses', 'contempo' ),
			'all_items' => __( 'All Statuses', 'contempo' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Statuses', 'contempo' ),
			'update_item' => __( 'Update Statuses', 'contempo' ),
			'add_new_item' => __( 'Add New Status', 'contempo' ),
			'new_item_name' => __( 'New Status Name', 'contempo' ),
			'separate_items_with_commas' => __( 'Separate Statuses with commas', 'contempo' ),
			'add_or_remove_items' => __( 'Add or remove Status', 'contempo' ),
			'choose_from_most_used' => __( 'Choose from the most used Statuses', 'contempo' )
		);
		register_taxonomy( 'ct_status', 'listings', array(
			'hierarchical' => false,
			'labels' => $statuslabels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'status' ),
		));

		if ( ! function_exists( 'status' ) ) {
			function status() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'ct_status', '', ', ', '' ) );
				echo esc_html($terms_as_text);
			}
		}

		$ct_city_town_or_village = isset( $ct_options['ct_city_town_or_village'] ) ? $ct_options['ct_city_town_or_village'] : '';

		if($ct_city_town_or_village == 'village') {
			// Village
			$citylabels = array(
				'name' => __( 'Village', 'contempo' ),
				'singular_name' => __( 'Village', 'contempo' ),
				'search_items' =>  __( 'Search Villages', 'contempo' ),
				'popular_items' => __( 'Popular Villages', 'contempo' ),
				'all_items' => __( 'All Villages', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Villages', 'contempo' ),
				'update_item' => __( 'Update Village', 'contempo' ),
				'add_new_item' => __( 'Add New Village', 'contempo' ),
				'new_item_name' => __( 'New Village Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Villages with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Villages', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Villages', 'contempo' )
			);
		} elseif($ct_city_town_or_village == 'town') {
			// Town
			$citylabels = array(
				'name' => __( 'Town', 'contempo' ),
				'singular_name' => __( 'Town', 'contempo' ),
				'search_items' =>  __( 'Search Towns', 'contempo' ),
				'popular_items' => __( 'Popular Towns', 'contempo' ),
				'all_items' => __( 'All Towns', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Towns', 'contempo' ),
				'update_item' => __( 'Update Town', 'contempo' ),
				'add_new_item' => __( 'Add New City', 'contempo' ),
				'new_item_name' => __( 'New Town Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Towns with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Towns', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Towns', 'contempo' )
			);
		} else {
			// City
			$citylabels = array(
				'name' => __( 'City', 'contempo' ),
				'singular_name' => __( 'City', 'contempo' ),
				'search_items' =>  __( 'Search Cities', 'contempo' ),
				'popular_items' => __( 'Popular Cities', 'contempo' ),
				'all_items' => __( 'All Cities', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Cities', 'contempo' ),
				'update_item' => __( 'Update City', 'contempo' ),
				'add_new_item' => __( 'Add New City', 'contempo' ),
				'new_item_name' => __( 'New City Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Cities with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Cities', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Cities', 'contempo' )
			);
		}

		register_taxonomy( 'city', 'listings', array(
			'hierarchical' => false,
			'labels' => $citylabels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'city' ),
		));

		if ( ! function_exists( 'city' ) ) {
			function city() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
				echo esc_html($terms_as_text);
			}
		}

		// State
		$ct_state_or_area = isset( $ct_options['ct_state_or_area'] ) ? $ct_options['ct_state_or_area'] : '';

		if($ct_state_or_area == 'area') {

			$arealabels = array(
				'name' => __( 'Area', 'contempo' ),
				'singular_name' => __( 'Area', 'contempo' ),
				'search_items' =>  __( 'Search Areas', 'contempo' ),
				'popular_items' => __( 'Popular Areas', 'contempo' ),
				'all_items' => __( 'All Areas', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Areas', 'contempo' ),
				'update_item' => __( 'Update Area', 'contempo' ),
				'add_new_item' => __( 'Add New Area', 'contempo' ),
				'new_item_name' => __( 'New Area Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Area with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Areas', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Areas', 'contempo' )
			);
			register_taxonomy( 'state', 'listings', array(
				'hierarchical' => false,
				'labels' => $arealabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'area' ),
			));

		} elseif($ct_state_or_area == 'suburb') {

			$arealabels = array(
				'name' => __( 'Suburb', 'contempo' ),
				'singular_name' => __( 'Suburb', 'contempo' ),
				'search_items' =>  __( 'Search Suburbs', 'contempo' ),
				'popular_items' => __( 'Popular Suburbs', 'contempo' ),
				'all_items' => __( 'All Suburbs', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Suburbs', 'contempo' ),
				'update_item' => __( 'Update Suburb', 'contempo' ),
				'add_new_item' => __( 'Add New Suburb', 'contempo' ),
				'new_item_name' => __( 'New Suburb Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Suburb with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Suburbs', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Suburbs', 'contempo' )
			);
			register_taxonomy( 'state', 'listings', array(
				'hierarchical' => false,
				'labels' => $arealabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'suburb' ),
			));

		} elseif($ct_state_or_area == 'province') {

			$arealabels = array(
				'name' => __( 'Province', 'contempo' ),
				'singular_name' => __( 'Province', 'contempo' ),
				'search_items' =>  __( 'Search Provinces', 'contempo' ),
				'popular_items' => __( 'Popular Provinces', 'contempo' ),
				'all_items' => __( 'All Provinces', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Provinces', 'contempo' ),
				'update_item' => __( 'Update Province', 'contempo' ),
				'add_new_item' => __( 'Add New Province', 'contempo' ),
				'new_item_name' => __( 'New Province Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Province with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Provinces', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Provinces', 'contempo' )
			);
			register_taxonomy( 'state', 'listings', array(
				'hierarchical' => false,
				'labels' => $arealabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'province' ),
			));

		} else {

			$statelabels = array(
				'name' => __( 'State', 'contempo' ),
				'singular_name' => __( 'State', 'contempo' ),
				'search_items' =>  __( 'Search States', 'contempo' ),
				'popular_items' => __( 'Popular States', 'contempo' ),
				'all_items' => __( 'All States', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit States', 'contempo' ),
				'update_item' => __( 'Update State', 'contempo' ),
				'add_new_item' => __( 'Add New State', 'contempo' ),
				'new_item_name' => __( 'New State Name', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate States with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove States', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used States', 'contempo' )
			);
			register_taxonomy( 'state', 'listings', array(
				'hierarchical' => false,
				'labels' => $statelabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'state' ),
			));
		}

		if ( ! function_exists( 'state' ) ) {
			function state() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
				echo esc_html($terms_as_text);
			}
		}

		// Zipcode
		$ct_zip_or_post = isset( $ct_options['ct_zip_or_post'] ) ? $ct_options['ct_zip_or_post'] : '';

		if($ct_zip_or_post == 'postcode') {

			$postlabels = array(
				'name' => __( 'Postcode', 'contempo' ),
				'singular_name' => __( 'Postcode', 'contempo' ),
				'search_items' =>  __( 'Search Postcodes', 'contempo' ),
				'popular_items' => __( 'Popular Postcodes', 'contempo' ),
				'all_items' => __( 'All Postcodes', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Postcode', 'contempo' ),
				'update_item' => __( 'Update Postcode', 'contempo' ),
				'add_new_item' => __( 'Add New Postcode', 'contempo' ),
				'new_item_name' => __( 'New Postcode', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Postcodes with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Postcodes', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Postcodes', 'contempo' )
			);
			register_taxonomy( 'zipcode', 'listings', array(
				'hierarchical' => false,
				'labels' => $postlabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'postcode' ),
			));

		} elseif($ct_zip_or_post == 'postalcode') {

			$postlabels = array(
				'name' => __( 'Postal Code', 'contempo' ),
				'singular_name' => __( 'Postal Code', 'contempo' ),
				'search_items' =>  __( 'Search Postal Codes', 'contempo' ),
				'popular_items' => __( 'Popular Postal Codes', 'contempo' ),
				'all_items' => __( 'All Postal Codes', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Postal Code', 'contempo' ),
				'update_item' => __( 'Update Postal Code', 'contempo' ),
				'add_new_item' => __( 'Add New Postal Code', 'contempo' ),
				'new_item_name' => __( 'New Postal Code', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Postal Codes with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Postal Codes', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Postal Codes', 'contempo' )
			);
			register_taxonomy( 'zipcode', 'listings', array(
				'hierarchical' => false,
				'labels' => $postlabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'postalcode' ),
			));

		} else {

			$ziplabels = array(
				'name' => __( 'Zipcode', 'contempo' ),
				'singular_name' => __( 'Zipcode', 'contempo' ),
				'search_items' =>  __( 'Search Zipcodes', 'contempo' ),
				'popular_items' => __( 'Popular Zipcodes', 'contempo' ),
				'all_items' => __( 'All Zipcodes', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Zipcode', 'contempo' ),
				'update_item' => __( 'Update Zipcode', 'contempo' ),
				'add_new_item' => __( 'Add New Zipcode', 'contempo' ),
				'new_item_name' => __( 'New Zipcode', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Zipcodes with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Zipcodes', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Zipcodes', 'contempo' )
			);
			register_taxonomy( 'zipcode', 'listings', array(
				'hierarchical' => false,
				'labels' => $ziplabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'zipcode' ),
			));
			
		}

		if ( ! function_exists( 'zipcode' ) ) {
			function zipcode() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );
				echo esc_html($terms_as_text);
			}
		}

		// Country
		$countrylabels = array(
			'name' => __( 'Country', 'contempo' ),
			'singular_name' => __( 'Country', 'contempo' ),
			'search_items' =>  __( 'Search Countries', 'contempo' ),
			'popular_items' => __( 'Popular Countries', 'contempo' ),
			'all_items' => __( 'All Countries', 'contempo' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Countries', 'contempo' ),
			'update_item' => __( 'Update Countries', 'contempo' ),
			'add_new_item' => __( 'Add New Countries', 'contempo' ),
			'new_item_name' => __( 'New Country Name', 'contempo' ),
			'separate_items_with_commas' => __( 'Separate Countries with commas', 'contempo' ),
			'add_or_remove_items' => __( 'Add or remove Countries', 'contempo' ),
			'choose_from_most_used' => __( 'Choose from the most used Countries', 'contempo' )
		);
		register_taxonomy( 'country', 'listings', array(
			'hierarchical' => false,
			'labels' => $countrylabels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'country' ),
		));

		if ( ! function_exists( 'country' ) ) {
			function country() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'country', '', ', ', '' ) );
				if(!empty($terms_as_text)) {
					echo ', ' . esc_html($terms_as_text);
				}
			}
		}

		// Country
		$countylabels = array(
			'name' => __( 'County', 'contempo' ),
			'singular_name' => __( 'County', 'contempo' ),
			'search_items' =>  __( 'Search Counties', 'contempo' ),
			'popular_items' => __( 'Popular Counties', 'contempo' ),
			'all_items' => __( 'All Counties', 'contempo' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Counties', 'contempo' ),
			'update_item' => __( 'Update Counties', 'contempo' ),
			'add_new_item' => __( 'Add New Counties', 'contempo' ),
			'new_item_name' => __( 'New County Name', 'contempo' ),
			'separate_items_with_commas' => __( 'Separate Counties with commas', 'contempo' ),
			'add_or_remove_items' => __( 'Add or remove Counties', 'contempo' ),
			'choose_from_most_used' => __( 'Choose from the most used Counties', 'contempo' )
		);
		register_taxonomy( 'county', 'listings', array(
			'hierarchical' => false,
			'labels' => $countylabels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'county' ),
		));

		if ( ! function_exists( 'county' ) ) {
			function county() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'county', '', ', ', '' ) );
				if(!empty($terms_as_text)) {
					echo ', ' . esc_html($terms_as_text);
				}
			}
		}

		// Community
		$ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

		if($ct_community_neighborhood_or_district == 'neighborhood') {

			$neighborhoodlabels = array(
				'name' => __( 'Neighborhood', 'contempo' ),
				'singular_name' => __( 'Neighborhood', 'contempo' ),
				'search_items' =>  __( 'Search Neighborhoods', 'contempo' ),
				'popular_items' => __( 'Popular Neighborhoods', 'contempo' ),
				'all_items' => __( 'All Neighborhoods', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Neighborhood', 'contempo' ),
				'update_item' => __( 'Update Neighborhood', 'contempo' ),
				'add_new_item' => __( 'Add New Neighborhood', 'contempo' ),
				'new_item_name' => __( 'New Neighborhood', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Neighborhoods with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Neighborhoods', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Neighborhoods', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $neighborhoodlabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'neighborhood' ),
			));
			
		} elseif($ct_community_neighborhood_or_district == 'suburb') {

			$suburblabels = array(
				'name' => __( 'Suburb', 'contempo' ),
				'singular_name' => __( 'Suburb', 'contempo' ),
				'search_items' =>  __( 'Search Suburbs', 'contempo' ),
				'popular_items' => __( 'Popular Suburbs', 'contempo' ),
				'all_items' => __( 'All Suburbs', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Suburb', 'contempo' ),
				'update_item' => __( 'Update Suburb', 'contempo' ),
				'add_new_item' => __( 'Add New Suburb', 'contempo' ),
				'new_item_name' => __( 'New Suburb', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Suburbs with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Suburbs', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Suburbs', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $suburblabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'suburb' ),
			));

		} elseif($ct_community_neighborhood_or_district == 'district') {

			$districtlabels = array(
				'name' => __( 'District', 'contempo' ),
				'singular_name' => __( 'District', 'contempo' ),
				'search_items' =>  __( 'Search Districts', 'contempo' ),
				'popular_items' => __( 'Popular Districts', 'contempo' ),
				'all_items' => __( 'All Districts', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit District', 'contempo' ),
				'update_item' => __( 'Update District', 'contempo' ),
				'add_new_item' => __( 'Add New District', 'contempo' ),
				'new_item_name' => __( 'New District', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Districts with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Districts', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Districts', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $districtlabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'district' ),
			));

		} elseif($ct_community_neighborhood_or_district == 'building') {

			$buildinglabels = array(
				'name' => __( 'Building', 'contempo' ),
				'singular_name' => __( 'Building', 'contempo' ),
				'search_items' =>  __( 'Search Buildings', 'contempo' ),
				'popular_items' => __( 'Popular Buildings', 'contempo' ),
				'all_items' => __( 'All Buildings', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Building', 'contempo' ),
				'update_item' => __( 'Update Building', 'contempo' ),
				'add_new_item' => __( 'Add New Building', 'contempo' ),
				'new_item_name' => __( 'New Building', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Buildings with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Buildings', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Buildings', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $buildinglabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'building' ),
			));

		} elseif($ct_community_neighborhood_or_district == 'complex') {

			$complexlabels = array(
				'name' => __( 'Complex', 'contempo' ),
				'singular_name' => __( 'Complex', 'contempo' ),
				'search_items' =>  __( 'Search Complexes', 'contempo' ),
				'popular_items' => __( 'Popular Complexes', 'contempo' ),
				'all_items' => __( 'All Complexes', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Complex', 'contempo' ),
				'update_item' => __( 'Update Complex', 'contempo' ),
				'add_new_item' => __( 'Add New Complex', 'contempo' ),
				'new_item_name' => __( 'New Complex', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Complexes with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Complexes', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Complexes', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $complexlabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'complex' ),
			));

		} elseif($ct_community_neighborhood_or_district == 'borough') {

			$boroughlabels = array(
				'name' => __( 'Borough', 'contempo' ),
				'singular_name' => __( 'Borough', 'contempo' ),
				'search_items' =>  __( 'Search Boroughs', 'contempo' ),
				'popular_items' => __( 'Popular Boroughs', 'contempo' ),
				'all_items' => __( 'All Boroughs', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Borough', 'contempo' ),
				'update_item' => __( 'Update Borough', 'contempo' ),
				'add_new_item' => __( 'Add New Borough', 'contempo' ),
				'new_item_name' => __( 'New Borough', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Boroughs with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Boroughs', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Boroughs', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $boroughlabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'building' ),
			));

		} elseif($ct_community_neighborhood_or_district == 'sector') {

			$sectorlabels = array(
				'name' => __( 'Sector', 'contempo' ),
				'singular_name' => __( 'Sector', 'contempo' ),
				'search_items' =>  __( 'Search Sectors', 'contempo' ),
				'popular_items' => __( 'Popular Sectors', 'contempo' ),
				'all_items' => __( 'All Sectors', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Sector', 'contempo' ),
				'update_item' => __( 'Update Sector', 'contempo' ),
				'add_new_item' => __( 'Add New Sector', 'contempo' ),
				'new_item_name' => __( 'New Sector', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Sectors with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Sectors', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Sectors', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $sectorlabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'sector' ),
			));

		} else {

			$communitylabels = array(
				'name' => __( 'Community', 'contempo' ),
				'singular_name' => __( 'Community', 'contempo' ),
				'search_items' =>  __( 'Search Communities', 'contempo' ),
				'popular_items' => __( 'Popular Communities', 'contempo' ),
				'all_items' => __( 'All Communities', 'contempo' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Community', 'contempo' ),
				'update_item' => __( 'Update Community', 'contempo' ),
				'add_new_item' => __( 'Add New Community', 'contempo' ),
				'new_item_name' => __( 'New Community', 'contempo' ),
				'separate_items_with_commas' => __( 'Separate Communities with commas', 'contempo' ),
				'add_or_remove_items' => __( 'Add or remove Communities', 'contempo' ),
				'choose_from_most_used' => __( 'Choose from the most used Communities', 'contempo' )
			);
			register_taxonomy( 'community', 'listings', array(
				'hierarchical' => false,
				'labels' => $communitylabels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'community' ),
			));
		}

		if ( ! function_exists( 'community' ) ) {
			function community() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'community', '', ', ', '' ) );
				echo esc_html($terms_as_text);
			}
		}

		// Additional Features
		$addfeatlabels = array(
			'name' => __( 'Additional Features', 'contempo' ),
			'singular_name' => __( 'Additional Feature', 'contempo' ),
			'search_items' =>  __( 'Search Additional Features', 'contempo' ),
			'popular_items' => __( 'Popular Additional Features', 'contempo' ),
			'all_items' => __( 'All Additional Features', 'contempo' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Additional Features', 'contempo' ),
			'update_item' => __( 'Update Additional Feature', 'contempo' ),
			'add_new_item' => __( 'Add New Additional Feature', 'contempo' ),
			'new_item_name' => __( 'New Additional Feature', 'contempo' ),
			'separate_items_with_commas' => __( 'Separate Additional Features with commas', 'contempo' ),
			'add_or_remove_items' => __( 'Add or remove Additional Features', 'contempo' ),
			'choose_from_most_used' => __( 'Choose from the most used Additional Features', 'contempo' )
		);
		register_taxonomy( 'additional_features', 'listings', array(
			'hierarchical' => false,
			'labels' => $addfeatlabels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'features' ),
		));

		if ( ! function_exists( 'addfeat' ) ) {
			function addfeat() {
				global $post;
				global $wp_query;
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'additional_features', '', ', ', '' ) );
				echo esc_html($terms_as_text);
			}
		}

		if ( ! function_exists( 'addfeatlist' ) ) {
			function addfeatlist () {
				global $post;
				$terms = get_the_terms($post->ID, 'additional_features');
				if ($terms) {
					echo '<h4 class="border-bottom marB20">' . __('Property Features', 'contempo') . '</h4>';
					echo '<ul class="propfeatures col span_6">';
					$count = 0;
					foreach ($terms as $taxindex => $taxitem) {
						echo '<li><i class="fa fa-check"></i>' . $taxitem->name . '</li>';
						$count++;
						if ($count == 6) {
							echo '</ul><ul class="propfeatures col span_6">';
							$count = 0;
						}
					}
					echo '</ul>';
					echo '<div class="clear"></div>';
				} else {
					
				}
			}
		}

	}

}

?>