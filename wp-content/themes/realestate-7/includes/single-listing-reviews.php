<?php
/**
 * Single Listing Reviews
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';
$ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

do_action('before_single_listing_reviews');

if($ct_listing_reviews == 'yes') {
	echo '<!-- Reviews -->';
	echo '<div id="listing-reviews">';
		if($ct_single_listing_content_layout_type == 'accordion') {
		    echo '<h4 id="listing-reviews-info" class="info-toggle border-bottom marB18">';
		        comments_number( __('No Reviews', 'contempo'), __('1 Review', 'contempo'), __( '% Reviews', 'contempo') );
		    echo '</h4>';
		} else {
			echo '<h4 id="listing-reviews-info" class="border-bottom marB18">';
		        comments_number( __('No Reviews', 'contempo'), __('1 Review', 'contempo'), __( '% Reviews', 'contempo') );
		    echo '</h4>';
		}
		echo '<div class="info-inner">';
		    comments_template();
		echo '</div>';
	echo '</div>';
	echo '<!-- //Reviews -->';
}

?>