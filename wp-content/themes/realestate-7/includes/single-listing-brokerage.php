<?php
/**
 * Single Listing Brokerage
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

do_action('before_single_listing_brokerage');

echo '<!-- Brokerage -->';
echo '<div id="listing-brokerage">';
    ct_brokered_by();
echo '</div>';
echo '<!-- //Brokerage -->';

?>