<?php
/**
 * Single Listing Header
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
$ct_single_listing_header_layout = isset( $ct_options['ct_single_listing_header_layout']['enabled'] ) ? $ct_options['ct_single_listing_header_layout']['enabled'] : '';

$ct_property_type = strip_tags( get_the_term_list( $wp_query->post->ID, 'property_type', '', ', ', '' ) );

do_action('before_single_listing_location');

echo '<!-- Location -->';
echo '<header class="listing-location">';

    if ($ct_single_listing_header_layout) {

        foreach ($ct_single_listing_header_layout as $key => $value) {
        
            switch($key) {

            // Status
            case 'listing_status' :   

                echo '<div class="snipe-wrap">';
                    if(class_exists('CoAuthors_Plus')) {
                        if(2 == count( get_coauthors( get_the_id()))) {
                            echo '<h6 class="snipe co-listing"><span>' . __('Co-listing', 'contempo') . '</span></h6>';
                        }
                    }
                    ct_status_featured();
                    ct_status();
                    echo '<div class="clear"></div>';
                echo '</div>';
        
            break;

            // Title
            case 'listing_title' :

               echo '<h1 id="listing-title" class="marT24 marB0">';
                    ct_listing_title();
                echo '</h1>';
                
            break;

            // City, State, Zip/Postcode
            case 'listing_city_state_zip' :

                echo '<p class="location marB0">';
                    city();
                    echo ', ';
                    state();
                    echo ' ';
                    zipcode();
                    //echo ' ';
                    country();
                echo '</p>';
                
            break;

            // Map Button
            case 'listing_map_btn' :

                echo '<div id="listing-map-btn">';
                    echo '<a href="#listing-location">';
                        echo '<i class="fas fa-map-marker-alt"></i>';
                        echo '<span id="map-btn-label">' . __('Map', 'contempo') . '</span>';
                    echo '</a>';
                echo '</div>';
            break;

            }

        }
        
    } else {

        echo '<div class="snipe-wrap">';
            if(class_exists('CoAuthors_Plus')) {
                if ( 2 == count( get_coauthors( get_the_id() ) ) ) {
                    echo '<h6 class="snipe co-listing"><span>' . __('Co-listing', 'contempo') . '</span></h6>';
                }
            }
            ct_status();
            echo '<div class="clear"></div>';
        echo '</div>';
        echo '<h2 class="marT5 marB0">';
            ct_listing_title();
        echo '</h2>';
        echo '<p class="location marB0">';
            city() . ', ' . state() . ' ' . zipcode() . ' ' . country();
        echo '</p>';

    }

    if($ct_listing_single_layout == 'listings-three' || $ct_listing_single_layout == 'listings-four') {
        echo '<div id="listing-price-type">';
            get_template_part('includes/single-listing-price');

            if(!has_term(array('for-rent', 'rental', 'lease'), 'ct_status', get_the_ID())) {
                get_template_part('includes/single-listing-estimated-payment');
            }
            
            if(has_term(array('for-rent', 'rental', 'lease'), 'ct_status', get_the_ID())) {
                if(!empty($ct_property_type)) {
                    echo '<p id="property-type" class="muted">';
                        echo esc_html($ct_property_type);
                    echo '</p>';
                }
            }
        echo '</div>';
    }
        
echo '</header>';
echo '<!--//Location -->';