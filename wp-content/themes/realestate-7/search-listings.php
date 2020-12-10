<?php
/**
 * Search Listings Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
get_header();

global $ct_options;
$ct_home_adv_search_style                     = isset( $ct_options['ct_home_adv_search_style'] ) ? $ct_options['ct_home_adv_search_style'] : '';
$ct_header_listing_search_hide_homepage       = isset( $ct_options['ct_header_listing_search_hide_homepage'] ) ? esc_html( $ct_options['ct_header_listing_search_hide_homepage'] ) : '';
$ct_disable_listing_search_results_adv_search = isset( $ct_options['ct_disable_listing_search_results_adv_search'] ) ? $ct_options['ct_disable_listing_search_results_adv_search'] : '';
$ct_search_results_layout                     = isset( $ct_options['ct_search_results_layout'] ) ? $ct_options['ct_search_results_layout'] : '';
$ct_search_results_listing_style              = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
$ct_currency                                  = isset( $ct_options['ct_currency'] ) ? $ct_options['ct_currency'] : '';
$ct_currency_placement                        = isset( $ct_options['ct_currency_placement'] ) ? $ct_options['ct_currency_placement'] : '';
$ct_sq                                        = isset( $ct_options['ct_sq'] ) ? $ct_options['ct_sq'] : '';
$ct_acres                                     = isset( $ct_options['ct_acres'] ) ? $ct_options['ct_acres'] : '';
$ct_header_listing_search                     = isset( $ct_options['ct_header_listing_search'] ) ? esc_html( $ct_options['ct_header_listing_search'] ) : '';
$ct_enable_front_end_login                    = isset( $ct_options['ct_enable_front_end_login'] ) ? esc_html( $ct_options['ct_enable_front_end_login'] ) : '';
$ct_listing_email_alerts_page_id              = isset( $ct_options['ct_listing_email_alerts_page_id'] ) ? esc_attr( $ct_options['ct_listing_email_alerts_page_id'] ) : '';

$ct_bed_beds_or_bedrooms    = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? esc_html( $ct_options['ct_bed_beds_or_bedrooms'] ) : '';
$ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? esc_html( $ct_options['ct_bath_baths_or_bathrooms'] ) : '';

if ( $ct_bed_beds_or_bedrooms == 'rooms' ) {
	$ct_bed_beds_or_bedrooms_label = __( 'Rooms', 'contempo' );
} elseif ( $ct_bed_beds_or_bedrooms == 'bedrooms' ) {
	$ct_bed_beds_or_bedrooms_label = __( 'Bedrooms', 'contempo' );
} elseif ( $ct_bed_beds_or_bedrooms == 'beds' ) {
	$ct_bed_beds_or_bedrooms_label = __( 'Beds', 'contempo' );
} else {
	$ct_bed_beds_or_bedrooms_label = __( 'Bed', 'contempo' );
}

if ( $ct_bath_baths_or_bathrooms == 'bathrooms' ) {
	$ct_bath_baths_or_bathrooms = __( 'Bathrooms', 'contempo' );
} elseif ( $ct_bath_baths_or_bathrooms == 'baths' ) {
	$ct_bath_baths_or_bathrooms = __( 'Baths', 'contempo' );
} else {
	$ct_bath_baths_or_bathrooms = __( 'Bath', 'contempo' );
}

/*-----------------------------------------------------------------------------------*/
/* Save the existing query */
/*-----------------------------------------------------------------------------------*/

global $wp_query;

$existing_query_obj = $wp_query;

$search_values = getSearchArgs();

$search_values["posts_per_page"] = 6;

//file_put_contents(dirname(__FILE__)."/admin/log.theme-functions", "search-listing one\r\n", FILE_APPEND);

if ( class_exists( "IDX_Query" ) ) {
	$idx_query = new IDX_Query( $search_values );
}
//file_put_contents(dirname(__FILE__)."/admin/log.theme-functions", "search-listing two\r\n", FILE_APPEND);

$wp_query = new WP_Query( array_merge( $search_values, [ 'ep_integrate' => true, ] ) );

//file_put_contents(dirname(__FILE__)."/admin/log.theme-functions", "search-listing three\r\n", FILE_APPEND);

// save the query for later because our consumers, eg grid, map previous next buttons
// etc reset the global query
$queryBuffer = $wp_query;

$total_results = $wp_query->found_posts;
//file_put_contents(dirname(__FILE__)."/admin/log.theme-functions", "total_results: ".$total_results."\r\n", FILE_APPEND);

/*-----------------------------------------------------------------------------------*/
/* Prepare the title string by looping through all
/* the values we're going to query and put them together
/*-----------------------------------------------------------------------------------*/

$search_params = array();

if ( ! empty( $_GET['ct_property_type'] ) && ! is_numeric( $_GET['ct_property_type'] ) ) {

	if ( is_array( $_GET['ct_property_type'] ) ) {
		$property_types = $_GET['ct_property_type'];
		foreach ( $property_types as $type ) {
			$search_params[] = $type;
		}
	} else {
		$search_params[] = isset( $_GET['ct_property_type'] ) ? $_GET['ct_property_type'] : '';
	}

}

if ( ! empty( $_GET['ct_ct_status_multi'] ) && ! is_numeric( $_GET['ct_ct_status_multi'] ) ) {

	if ( is_array( $_GET['ct_ct_status_multi'] ) ) {
		$statuses = $_GET['ct_ct_status_multi'];
		foreach ( $statuses as $status ) {
			$search_params[] = $status;
		}
	} else {
		$search_params[] = isset( $_GET['ct_ct_status_multi'] ) ? $_GET['ct_ct_status_multi'] : '';
	}

}

if ( ! empty( $_GET['ct_ct_status'] ) && ! is_numeric( $_GET['ct_ct_status'] ) ) {
	$search_params[] = isset( $_GET['ct_ct_status'] ) ? $_GET['ct_ct_status'] : '';
}

if ( ! empty( $_GET['ct_beds'] ) && $_GET['ct_beds'] > 0 ) {
	$ct_beds         = isset( $_GET['ct_beds'] ) ? $_GET['ct_beds'] : '';
	$search_params[] = $ct_beds . ' ' . $ct_bed_beds_or_bedrooms_label;
}

if ( ! empty( $_GET['ct_baths'] ) && $_GET['ct_baths'] > 0 ) {
	$ct_baths        = isset( $_GET['ct_baths'] ) ? $_GET['ct_baths'] : '';
	$search_params[] = $ct_baths . ' ' . $ct_bath_baths_or_bathrooms;
}

if ( ! empty( $_GET['ct_beds_plus'] ) && $_GET['ct_beds_plus'] > 0 ) {
	$ct_beds_plus    = isset( $_GET['ct_beds_plus'] ) ? $_GET['ct_beds_plus'] : '';
	$search_params[] = $ct_beds_plus . '+ ' . $ct_bed_beds_or_bedrooms_label;
}

if ( ! empty( $_GET['ct_baths_plus'] ) && $_GET['ct_baths_plus'] > 0 ) {
	$ct_baths_plus   = isset( $_GET['ct_baths_plus'] ) ? $_GET['ct_baths_plus'] : '';
	$search_params[] = $ct_baths_plus . '+ ' . $ct_bath_baths_or_bathrooms;
}

if ( ! empty( $_GET['ct_city'] ) && ! is_numeric( $_GET['ct_city'] ) ) {
	$ct_city         = isset( $_GET['ct_city'] ) ? $_GET['ct_city'] : '';
	$ct_city         = preg_replace( '/[^A-Za-z0-9\-]/', '', $ct_city );
	$search_params[] = $ct_city;
}

if ( ! empty( $_GET['ct_state'] ) && ! is_numeric( $_GET['ct_state'] ) ) {
	$search_params[] = isset( $_GET['ct_state'] ) ? $_GET['ct_state'] : '';
}

if ( ! empty( $_GET['ct_zipcode'] ) && $_GET['ct_zipcode'] > 0 ) {
	$search_params[] = isset( $_GET['ct_zipcode'] ) ? $_GET['ct_zipcode'] : '';
}

if ( ! empty( $_GET['ct_country'] ) && ! is_numeric( $_GET['ct_country'] ) ) {
	$search_params[] = isset( $_GET['ct_country'] ) ? $_GET['ct_country'] : '';
}

if ( ! empty( $_GET['ct_community'] ) && ! is_numeric( $_GET['ct_community'] ) ) {
	$search_params[] = isset( $_GET['ct_community'] ) ? $_GET['ct_community'] : '';
}

if ( ! empty( $_GET['ct_year_from'] ) && is_numeric( $_GET['ct_year_from'] ) ) {
	$search_params[] = isset( $_GET['ct_year_from'] ) ? $_GET['ct_year_from'] : '';
}

if ( ! empty( $_GET['ct_year_to'] ) && is_numeric( $_GET['ct_year_to'] ) ) {
	$search_params[] = isset( $_GET['ct_year_to'] ) ? $_GET['ct_year_to'] : '';
}

if ( ! empty( $_GET['ct_price_from'] ) && $_GET['ct_price_from'] > 0 ) {
	$ct_price_from = isset( $_GET['ct_price_from'] ) ? $_GET['ct_price_from'] : '';
	if ( $ct_currency_placement == 'after' ) {
		$search_params[] = $ct_price_from . $ct_currency;
	} else {
		$search_params[] = $ct_currency . $ct_price_from;
	}
}

if ( ! empty( $_GET['ct_price_to'] ) && $_GET['ct_price_to'] > 0 ) {
	$ct_price_to = isset( $_GET['ct_price_to'] ) ? $_GET['ct_price_to'] : '';
	if ( $ct_currency_placement == 'after' ) {
		$search_params[] = $ct_price_to . $ct_currency;
	} else {
		$search_params[] = $ct_currency . $ct_price_to;
	}
}

if ( ! empty( $_GET['ct_sqft_from'] ) && $_GET['ct_sqft_from'] > 0 ) {
	$ct_sqft_from    = isset( $_GET['ct_sqft_from'] ) ? $_GET['ct_sqft_from'] : '';
	$ct_sqft_from    = str_replace( $ct_sq, '', $ct_sqft_from );
	$search_params[] = $ct_sqft_from . ' ' . ucfirst( $ct_sq );
}

if ( ! empty( $_GET['ct_sqft_to'] ) && $_GET['ct_sqft_to'] > 0 ) {
	$ct_sqft_to      = isset( $_GET['ct_sqft_to'] ) ? $_GET['ct_sqft_to'] : '';
	$ct_sqft_to      = str_replace( $ct_sq, '', $ct_sqft_to );
	$search_params[] = $ct_sqft_to . ' ' . ucfirst( $ct_sq );
}

if ( ! empty( $_GET['ct_lotsize_from'] ) && $_GET['ct_lotsize_from'] > 0 ) {
	$ct_lotsize_from = isset( $_GET['ct_lotsize_from'] ) ? $_GET['ct_lotsize_from'] : '';
	$ct_lotsize_from = str_replace( $ct_acres, '', $ct_lotsize_from );
	$search_params[] = $ct_lotsize_from . ' ' . ucfirst( $ct_acres );
}

if ( ! empty( $_GET['ct_lotsize_to'] ) && $_GET['ct_lotsize_to'] > 0 ) {
	$ct_lotsize_to   = isset( $_GET['ct_lotsize_to'] ) ? $_GET['ct_lotsize_to'] : '';
	$ct_lotsize_to   = str_replace( $ct_acres, '', $ct_lotsize_to );
	$search_params[] = $ct_lotsize_to . ' ' . ucfirst( $ct_acres );
}

if ( ! empty( $_GET['ct_mls'] ) && $_GET['ct_mls'] > 0 ) {
	$search_params[] = isset( $_GET['ct_mls'] ) ? $_GET['ct_mls'] : '';
}

$search_params = str_replace( '-', ' ', $search_params );
$search_params = array_map( 'ucwords', $search_params );

$search_params = implode( ', ', $search_params );


do_action( 'before_listings_search_header' );

if ( $ct_header_listing_search_hide_homepage == 'yes' ) {
	echo '<style>';
	echo '#header-search-wrap { display: block;}';
	echo '</style>';
}

if ( $ct_header_listing_search != 'yes' ) {
	echo '<!-- Title Header -->';
	echo '<header id="title-header" class="marB0">';
	echo '<div class="container">';
	echo '<h5 class="marT0 marB0 left muted">';
	echo '<span id="number-listings-found">' . esc_html( $total_results ) . '</span>';
	echo ' ';
	if ( $total_results != '1' ) {
		esc_html_e( 'listings found', 'contempo' );
	} else {
		esc_html_e( 'listing found', 'contempo' );
	}
	if ( $ct_options['ct_disable_google_maps_search'] == 'no' ) {
		echo '<div id="number-listings-progress">';
		echo '<img class="left" src="' . get_stylesheet_directory_uri() . '/images/loader.gif" />';
		echo __( 'Loading Results…', 'contempo' );
		echo '</div>';
	}
	echo '</h5>';
	echo '<div class="muted right">';
	esc_html_e( 'Find A Home', 'contempo' );
	echo '</div>';
	echo '<div class="clear"></div>';
	echo '</div>';
	echo '</header>';
	echo '<!-- //Title Header -->';
}

if ( $ct_disable_listing_search_results_adv_search != 'no' && $ct_search_results_layout == 'sidebyside' ) {

	if ( $ct_header_listing_search != 'yes' ) {
		do_action( 'before_listings_adv_search' );

		echo '<section class="side-by-side search-results advanced-search ' . $ct_home_adv_search_style . '">';
		echo '<div class="container">';
		get_template_part( '/includes/advanced-search' );
		echo '</div>';
		echo '</section>';
		echo '<div class="clear"></div>';
	}

}

do_action( 'before_listings_search_map' );

// Start Search Results Map
//wp_reset_query();
//wp_reset_postdata();

//$wp_query = new wp_query( $search_values );

if ( $ct_options['ct_disable_google_maps_search'] == 'no' ) {

	// We skip this check because we still want the map if no results
	// because we've added map drag / map zoom search
	//if($wp_query->have_posts() || $search_params == '' || $ct_header_listing_search == 'yes' ) {
	echo '<!-- Map -->';

	if ( $ct_search_results_layout == 'sidebyside' ) {
		echo '<div id="map-wrap" class="listings-results-map col span_6 side-map">';
	} else {
		echo '<div id="map-wrap" class="listings-results-map">';
	}



	// Marker Navigation
	ct_search_results_map_navigation();
	// Map
	//TODO:: open this function. Fix while loop this post
	ct_search_results_map();

	// restore the query:
	$wp_query = $queryBuffer;

	//}

	// End Search Results Map
	echo '</div>';
	echo '<!-- //Map -->';
	//}
}

if ( $ct_header_listing_search == 'yes' && $ct_search_results_layout != 'sidebyside' ) {
	echo '<!-- Title Header -->';
	echo '<header id="title-header" class="marT0 marB0">';
	echo '<div class="container">';
	echo '<h5 class="marT0 marB0 left muted">';
	echo '<span id="number-listings-found">' . esc_html( $total_results ) . '</span>';
	echo ' ';
	if ( $total_results != '1' ) {
		esc_html_e( 'listings found', 'contempo' );
	} else {
		esc_html_e( 'listing found', 'contempo' );
	}
	if ( $ct_options['ct_disable_google_maps_search'] == 'no' ) {
		echo '<div id="number-listings-progress">';
		echo '<img class="left" src="' . get_template_directory_uri() . '/images/loader.gif" />';
		echo __( 'Loading Results…', 'contempo' );
		echo '</div>';
	}
	//echo '<i id="number-listings-progress" class="fa fa-spinner fa-spin fa-fw"></i>';
	echo '</h5>';
	echo '<div class="muted right">';
	esc_html_e( 'Find A Home', 'contempo' );
	echo '</div>';
	echo '<div class="clear"></div>';
	echo '</div>';
	echo '</header>';
	echo '<!-- //Title Header -->';

	if ( $ct_search_results_layout != 'sidebyside' ) {
		echo '<!-- Searching On -->';
		echo '<div class="searching-on ' . $ct_home_adv_search_style . '">';
		echo '<div class="container">';
		echo '<span class="searching">' . __( 'Searching:', 'contempo' ) . '</span>';
		if ( ! empty( $search_params ) ) {
			echo '<span class="search-params">' . $search_params . '</span>';
		} else {
			echo '<span class="search-params">' . __( 'All listings', 'contempo' ) . '</span>';
		}
		if ( $ct_options['ct_disable_google_maps_search'] == 'no' ) {
			echo '<span class="map-toggle"><span id="text-toggle">' . __( 'Close Map', 'contempo' ) . '</span><i class="fa fa-minus-square-o"></i></span>';
		}
		echo '</div>';
		echo '</div>';
		echo '<!-- //Searching On -->';
	}
}

do_action( 'before_listings_searching_on' );

echo '<!-- Search Results -->';
if ( $ct_search_results_layout == 'sidebyside' ) {
	echo '<div class="col span_6 side-results">';
	echo '<div id="searching-on" class="border-bottom">';
	echo '<h5 id="searching-on" class="marT20 marB0 left"><strong>' . __( 'Searching:', 'contempo' ) . '</strong> ';
	if ( ! empty( $search_params ) ) {
		echo '<span id="search-params">' . $search_params . '</span>';
	} else {
		echo '<span id="search-params">' . __( 'All listings', 'contempo' ) . '</span>';
	}

	echo '</h5>';
	echo '<h5 class="marT20 marB0 right muted"><span id="number-listings-found">' . esc_html( $total_results ) . '</span> ';
	if ( $total_results != '1' ) {
		esc_html_e( 'listings found', 'contempo' );
	} else {
		esc_html_e( 'listing found', 'contempo' );
	}
	echo '</h5>';
	echo '<div class="clear"></div>';
	echo '</div>';
	if ( $ct_options['ct_disable_google_maps_search'] == 'no' ) {
		echo '<div id="number-listings-progress">';
		echo '<img class="left" src="' . get_template_directory_uri() . '/images/loader.gif" />';
		echo __( 'Loading Results…', 'contempo' );
		echo '</div>';
	}
}
if ( $ct_disable_listing_search_results_adv_search == 'no' && $ct_search_results_layout != 'sidebyside' ) {
	echo '<!-- Searching On -->';
	echo '<div class="searching-on ' . $ct_home_adv_search_style . '">';
	echo '<div class="container">';
	echo '<span class="searching">' . __( 'Searching:', 'contempo' ) . '</span>';
	if ( ! empty( $search_params ) ) {

		echo '<span class="search-params">' . $search_params . '</span>';
	} else {
		echo '<span class="search-params">' . __( 'All listings', 'contempo' ) . '</span>';
	}
	echo '<span class="map-toggle"><span id="text-toggle">' . __( 'Close Map', 'contempo' ) . '</span><i class="fa fa-minus-square-o"></i></span>';
	echo '</div>';
	echo '</div>';
	echo '<!-- //Searching On -->';

	do_action( 'before_listings_adv_search' );

	if ( $ct_disable_listing_search_results_adv_search == 'no' ) {
		echo '<section class="search-results advanced-search ' . $ct_home_adv_search_style . '">';
		echo '<div class="container">';
		get_template_part( '/includes/advanced-search' );
		echo '</div>';
		echo '</section>';
		echo '<div class="clear"></div>';
	}
}
?>

<?php do_action( 'before_listing_search_results' ); ?>

<script>
    jQuery(".pagination li a").on("click", function () {
        console.log('pagination click');
        jQuery("html, body").animate({scrollTop: 0}, "slow");
        return false;
    });
</script>

<div class="container">
    <!-- Listing Results -->
    <div id="listings-results" class="listing-search-results col span_12 first">

        <div id="listing-search-tools"
             class="col span_12 <?php if ( $ct_disable_listing_search_results_adv_search == 'yes' && $ct_search_results_layout != 'sidebyside' ) {
			     echo 'marT30';
		     } ?>">

			<?php if ( function_exists( 'ctea_show_alert_creation' ) ) {
				echo '<div class="col span_9 first">';
				if ( is_user_logged_in() ) { ?>
                    <form method="post" action="" class="form-searched-save-search left">
                        <input type="hidden" name="search_args"
                               value='<?php print base64_encode( serialize( $search_values ) ); ?>'>
                        <input type="hidden" name="search_URI"
                               value="<?php echo esc_html( $_SERVER['REQUEST_URI'] ); ?>">
                        <input type="hidden" name="action" value='ct_searched_save_search'>
                        <input type="hidden" name="ct_searched_save_search_ajax"
                               value="<?php echo wp_create_nonce( 'ct-searched-save-search-nounce' ) ?>">
                        <a id="searched-save-search"
                           class="btn save-btn"><?php _e( 'Save This Search?', 'contempo' ); ?></a>
                    </form>
                    <a id="view-saved" class="btn"
                       href="<?php echo get_page_link( $ct_listing_email_alerts_page_id ); ?>"><?php _e( 'View Saved', 'contempo' ); ?></a>
				<?php } elseif ( $ct_enable_front_end_login != 'no' ) { ?>
                    <a id="searched-save-search"
                       class="btn login-register save-btn"><?php _e( 'Save This Search?', 'contempo' ); ?></a>
				<?php }
				echo '</div>';
			} ?>
            <div class="col span_3">
				<?php ct_sort_by(); ?>
            </div>
        </div>

		<?php

		// Reset Query for Listings
		//wp_reset_query();
		//wp_reset_postdata();

		//$search_values['post_type'] = 'listings';
		$search_values['paged']     = ct_currentPage();
		$search_num                 = $ct_options['ct_listing_search_num'];
		$search_values['posts_per_page'] = $search_num;

		$wp_query = new wp_query( $search_values );

		if ( $ct_search_results_listing_style == 'list' ) {
			get_template_part( 'layouts/list' );
		} else {
			get_template_part( 'layouts/grid' );
		}

		// End Listing Results
		echo '<div class="clear"></div>';
		echo '</div>';
		echo '<!-- Listing Results -->';

		// Restore WP_Query object
		$wp_query = $existing_query_obj;

		echo '<div class="clear"></div>';
		echo '</div>';
		if ( $ct_search_results_layout == 'sidebyside' ) {
			echo '</div>';
		}
		echo '<!-- //Search Results -->';

		do_action( 'after_listing_search_results' );

		get_footer(); ?>
