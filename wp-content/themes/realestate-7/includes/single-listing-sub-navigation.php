<?php
/**
 * Single Listing Sub Navigation
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';
$ct_single_listing_content_layout = isset( $ct_options['ct_single_listing_content_layout']['enabled'] ) ? $ct_options['ct_single_listing_content_layout']['enabled'] : '';

if($ct_single_listing_content_layout_type == 'tabbed') {
    echo '<ul id="listing-sections-tab" class="tabs">';
} else {
    echo '<ul id="listing-sections">';
}

        echo '<li class="listing-nav-icon"><i class="fa fa-navicon"></i></li>';

        if(!empty($ct_single_listing_content_layout)) {

        foreach ($ct_single_listing_content_layout as $key => $value) {
        
            switch($key) {

                // Description
                case 'listing_content' :
                    
                    if($ct_single_listing_content_layout_type == 'tabbed') {
                        $ct_content = get_the_content();
                        if($ct_content != '') {
                            echo '<li><a href="#listing-content">' . __('Description', 'contempo') . '</a></li>';
                        }
                    }
                    
                break;

                // CT IDX Pro Info
                case 'listing_ct_idx_pro_info' :   

                    echo '<li><a href="#listing-idx-info">' . __('Details', 'contempo') . '</a></li>';
            
                break;

                // Open House
                case 'listing_open_house' :

                    $ct_todays_date = date("mdY");
                    $ct_open_house_entries = get_post_meta( get_the_ID(), '_ct_open_house', true );

                    foreach ( (array) $ct_open_house_entries as $key => $entry ) {
                        $ct_open_house_date = '';
                        if ( isset( $entry['_ct_open_house_date'] ) ) {
                            $ct_open_house_date = esc_html( $entry['_ct_open_house_date'] );
                            $ct_open_house_date_formatted = strftime('%m%d%Y', $ct_open_house_date);
                        }
                    }

                    if($ct_open_house_entries != '' && $ct_open_house_date != '' && $ct_open_house_date_formatted >= $ct_todays_date) {
                        echo '<li><a href="#listing-open-house">' . __('Open House', 'contempo') . '</a></li>';
                    }
                    
                break;

                // Floorplans
                case 'listing_floorplans' :

                    $ct_floor_entries = get_post_meta( get_the_ID(), '_ct_multiplan', true );
                    if($ct_floor_entries != '') {
                        echo '<li><a href="#listing-plans">' . __('Floor Plans', 'contempo') . '</a></li>';
                    }
                    
                break;

                // Rental Info
                case 'listing_rental_info' :

                    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_attr( $ct_options['ct_rentals_booking'] ) : '';
                    $checkin = get_post_meta($post->ID, "_ct_rental_checkin", true);
                    $checkout = get_post_meta($post->ID, "_ct_rental_checkout", true);
                    $extra_people = get_post_meta($post->ID, "_ct_rental_extra_people", true);
                    $cleaning = get_post_meta($post->ID, "_ct_rental_cleaning", true);
                    $cancellation = get_post_meta($post->ID, "_ct_rental_cancellation", true);
                    $deposit = get_post_meta($post->ID, "_ct_rental_deposit", true);
                    if($ct_rentals_booking == 'yes') {
                        if(!empty($checkin) || !empty($checkout) || !empty($extra_people) || !empty($cleaning) || !empty($cancellation) || !empty($deposit) ) {
                            echo '<li><a href="#listing-rental-info">' . __('Rental Info', 'contempo') . '</a></li>';
                        }
                    }
                    
                break;

                // Features
                case 'listing_features' :
                    
                    $ct_additional_features = get_the_terms($post->ID, 'additional_features');
                    if($ct_additional_features) {
                        echo '<li><a href="#listing-features">' . __('Features', 'contempo') . '</a></li>';
                    }
                    
                break;

                // Booking Calendar
                case 'listing_booking_calendar' :

                    $book_cal_shortcode = get_post_meta($post->ID, "_ct_booking_cal_shortcode", true);
                    if(!empty($book_cal_shortcode)) {
                        echo '<li><a href="#listing-booking-form">' . __('Booking', 'contempo') . '</a></li>';
                    }
                    
                break;

                // Attachments
                case 'listing_attachments' :

                    $fileattachments = get_post_meta( get_the_ID(), '_ct_files', 1 );
                    if(!empty($fileattachments)) {
                        echo '<li><a href="#listing-attachments">' . __('Attachments', 'contempo') . '</a></li>';
                    }
                    
                break;

                // Video
                case 'listing_video' :

                    $ct_video_url = get_post_meta($post->ID, "_ct_video", true);
                    if(!empty($ct_video_url)) {
                        echo '<li><a href="#listing-video">' . __('Video', 'contempo') . '</a></li>';
                    }
                    
                break;

                // Virtual Tour
                case 'listing_virtual_tour' :

                    $ct_virtual_tour = get_post_meta($post->ID, "_ct_virtual_tour", true);
                    $ct_virtual_tour_shortcode = get_post_meta($post->ID, "_ct_virtual_tour_shortcode", true);
                    $ct_virtual_tour_url = get_post_meta($post->ID, "_ct_virtual_tour_url", true);

                    if(!empty($ct_virtual_tour) || !empty($ct_virtual_tour_shortcode) || !empty($ct_virtual_tour_url)) {
                        echo '<li><a href="#listing-virtual-tour">' . __('Tour', 'contempo') . '</a></li>';
                    }
                    
                break;

                // Virtual Tour
                case 'listing_map' :

                    echo '<li><a href="#listing-location">' . __('Location', 'contempo') . '</a></li>';
                    
                break;

                // Yelp
                case 'listing_yelp' :

                    echo '<li><a href="#listing-nearby">' . __('Nearby', 'contempo') . '</a></li>';
                    
                break;

                // Reviews
                case 'listing_reviews' :

                    echo '<li><a href="#listing-reviews">' . __('Reviews', 'contempo') . '</a></li>';
                    
                break;
            
            }

        }
        
    } else {

        /*-----------------------------------------------------------------------------------*/
        /* For Legacy Users */
        /*-----------------------------------------------------------------------------------*/

        echo '<li><a href="#listing-features">' . __('Listing Features', 'contempo') . '</a></li>';
        echo '<li><a href="#location">' . __('Location', 'contempo') . '</a></li>';

    }

    if($ct_single_listing_content_layout_type != 'tabbed') {
        echo '<li><a href="#listing-contact">' . __('Contact', 'contempo') . '</a></li>';
    }

echo '</ul>';