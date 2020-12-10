<?php
/**
 * Single Listing Booking Calendar
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';
$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_attr( $ct_options['ct_rentals_booking'] ) : '';

echo '<!-- Booking Calendar -->';
$book_cal_shortcode = get_post_meta($post->ID, "_ct_booking_cal_shortcode", true);
if($ct_rentals_booking == 'yes' && !empty($book_cal_shortcode)) {
    echo '<div id="listing-booking-form" class="booking-form-calendar">';
	    if($ct_single_listing_content_layout_type == 'accordion') {
	        echo '<h4 id="book-this-listing" class="info-toggle border-bottom marB18">' . __('Book this listing', 'contempo') . '</h4>';
	    } else {
	    	echo '<h4 class="border-bottom marB18">' . __('Book this listing', 'contempo') . '</h4>';
	    }
        echo '<div class="info-inner">';
	        echo do_shortcode($book_cal_shortcode);
	        echo '<div class="clear"></div>';
	    echo '</div>';
    echo '</div>';
}
echo '<!-- //Booking Calendar -->';

?>