<?php
/**
 * Single Listing Estimated Payment
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;
$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';

do_action('before_single_ct_listing_estimated_payment');

if(!has_term(array('for-rent', 'rental', 'lease'), 'ct_status', get_the_ID())) {
	echo '<!-- Estimated Payment -->';
	if($ct_listing_single_layout != 'listings-three' && $ct_listing_single_layout != 'listings-four') {
		echo '<p class="est-payment marT0 marB0 muted padL30">';
	} else {
		echo '<p class="est-payment marT0 marB20 muted">';
	}
		echo __('Est. Payment', 'contempo') . ' ';
		echo '<a href="#loanCalc">';
		    ct_listing_estimated_payment();
	    echo '</a>';
	echo '</p>';
}

?>