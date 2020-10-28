<?php
/**
 * Single Listing Content
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';
$ct_single_listing_content_layout = isset( $ct_options['ct_single_listing_content_layout']['enabled'] ) ? $ct_options['ct_single_listing_content_layout']['enabled'] : '';
$ct_listing_single_content_show_more = isset( $ct_options['ct_listing_single_content_show_more'] ) ? $ct_options['ct_listing_single_content_show_more'] : '';

do_action('before_single_listing_content');
            
if($ct_single_listing_content_layout_type == 'tabbed') {
    echo '<div class="post-content inside">';
} else {
    echo '<div class="post-content">';
}

    if(!empty($ct_single_listing_content_layout)) {

        foreach ($ct_single_listing_content_layout as $key => $value) {
        
            switch($key) {

                // Content
                case 'listing_content' :   

                    do_action('before_single_listing_inner_content');

                    if($ct_listing_single_content_show_more == 'yes') {
                        echo '<div id="listing-content-show-more">';
                    } else {
                         echo '<div id="listing-content">';
                    }
                        the_content();

                        do_action('inside_single_listing_inner_content');
                        
                    echo '</div>';
                        echo '<div class="clear"></div>';

                    do_action('after_single_listing_inner_content');
            
                break;

                // CT IDX Pro Info
                case 'listing_ct_idx_pro_info' :   

                    get_template_part('includes/single-listing-ct-idx-pro-info');
            
                break;

                // Floorplans
                case 'listing_open_house' :

                    get_template_part('includes/single-listing-open-house');
                    
                break;

                // Floorplans
                case 'listing_floorplans' :

                    get_template_part('includes/single-listing-multi-floorplan');
                    
                break;

                // Energy Efficiency
                case 'listing_energy_efficiency' :

                   get_template_part('includes/single-listing-energy-efficiency');
                    
                break;

                // Rental Info
                case 'listing_rental_info' :

                   get_template_part('includes/single-listing-rental-info');
                    
                break;

                // Features
                case 'listing_features' :

                   get_template_part('includes/single-listing-features');
                    
                break;

                // Booking Calendar
                case 'listing_booking_calendar' :

                   get_template_part('includes/single-listing-booking-calendar');
                    
                break;

                // Attachments
                case 'listing_attachments' :

                    get_template_part('includes/single-listing-attachments');
                    
                break;

                // Video
                case 'listing_video' :

                    get_template_part('includes/single-listing-video');
                    
                break;

                // Virtual Tour
                case 'listing_virtual_tour' :

                    get_template_part('includes/single-listing-virtual-tour');
                    
                break;

                // Virtual Tour
                case 'listing_map' :

                    get_template_part('includes/single-listing-map');
                    
                break;

                // Yelp
                case 'listing_yelp' :

                    get_template_part('includes/single-listing-yelp');

                break;

                // Reviews
                case 'listing_reviews' :

                    get_template_part('includes/single-listing-reviews');
                    
                break;
            
            }

        }
        
    }

echo '</div>';