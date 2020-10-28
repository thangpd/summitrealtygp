<?php
/**
 * Single Listing Price
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

do_action('before_single_ct_listing_price');
            
echo '<!-- Price -->';
echo '<h4 class="price marT0 marB0">';
    ct_listing_price();
echo '</h4>';

?>