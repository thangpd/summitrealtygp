<?php
/**
 * Single Listing Features
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';
$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_attr( $ct_options['ct_rentals_booking'] ) : '';

$checkin = get_post_meta($post->ID, "_ct_rental_checkin", true);
$checkout = get_post_meta($post->ID, "_ct_rental_checkout", true);
$extra_people = get_post_meta($post->ID, "_ct_rental_extra_people", true);
$cleaning = get_post_meta($post->ID, "_ct_rental_cleaning", true);
$cancellation = get_post_meta($post->ID, "_ct_rental_cancellation", true);
$deposit = get_post_meta($post->ID, "_ct_rental_deposit", true);

do_action('before_single_listing_rental_info');

if($ct_rentals_booking == 'yes' && !empty($checkin) || !empty($checkout) || !empty($extra_people) || !empty($cleaning) || !empty($cancellation) || !empty($deposit)) {
    echo '<!-- Rental Info -->';
    echo '<div id="listing-rental-info">';
        if($ct_single_listing_content_layout_type == 'accordion') {
            echo '<h4 id="rental-info" class="info-toggle border-bottom marB20">' . __('Rental Information', 'contempo') . '</h4>';
        } else {
            echo '<h4 id="rental-info" class="border-bottom marB20">' . __('Rental Information', 'contempo') . '</h4>';
        }

        $checkin = get_post_meta($post->ID, "_ct_rental_checkin", true);
        $checkout = get_post_meta($post->ID, "_ct_rental_checkout", true);
        $rental_guests = get_post_meta($post->ID, "_ct_rental_guests", true);
        $min_stay = get_post_meta($post->ID, "_ct_rental_min_stay", true);

        if( !empty($checkin) || !empty($checkout) || !empty($rental_guests) || !empty($min_stay) ) {
            echo '<!-- Info -->';
            echo '<div class="info-inner">';
                echo '<ul class="propinfo marB0 pad0">';
                    ct_rental_info();
                echo '</ul>';
            echo '</div>';
            echo '<!-- //Info -->';
        }

        $extra_people = get_post_meta($post->ID, "_ct_rental_extra_people", true);
        $cleaning = get_post_meta($post->ID, "_ct_rental_cleaning", true);
        $cancellation = get_post_meta($post->ID, "_ct_rental_cancellation", true);
        $deposit = get_post_meta($post->ID, "_ct_rental_deposit", true);

        if( !empty($extra_people) || !empty($cleaning) || !empty($cancellation) || !empty($deposit) ) {
            echo '<!-- Costs & Fees -->';
            echo '<h5 class="marT20">' . __('Prices', 'contempo') . '</h5>';
            echo '<ul class="propinfo marB0 pad0">';
                ct_rental_costs();
            echo '</ul>';
            echo '<!-- //Costs & Fees -->';
        }
    echo '</div>';
    echo '<!-- //Rental Info -->';
}

?>