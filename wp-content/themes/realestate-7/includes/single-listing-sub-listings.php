<?php
/**
 * Single Listing Sub Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;
$ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

do_action('before_single_listing_community');

$terms = strip_tags( get_the_term_list( $wp_query->post->ID, 'community', '', ', ', '' ) );
$term = get_term_by('name', $terms, 'community');


if(!empty($term) && $term->count > 1) {
    echo '<!-- Sub Listings -->';
    echo '<div class="marb20 sub-listings col span_12 first">';

    	if($ct_community_neighborhood_or_district == 'neighborhood') {
        	echo '<h4 class="border-bottom marB20">' . __('Other Listings in Neighborhood', 'contempo') . '</h4>';
        } elseif($ct_community_neighborhood_or_district == 'suburb') {
        	echo '<h4 class="border-bottom marB20">' . __('Other Listings in Suburb', 'contempo') . '</h4>';
        } elseif($ct_community_neighborhood_or_district == 'district') {
        	echo '<h4 class="border-bottom marB20">' . __('Other Listings in District', 'contempo') . '</h4>';
        } elseif($ct_community_neighborhood_or_district == 'schooldistrict') {
        	echo '<h4 class="border-bottom marB20">' . __('Other Listings in School District', 'contempo') . '</h4>';
        } elseif($ct_community_neighborhood_or_district == 'building') {
        	echo '<h4 class="border-bottom marB20">' . __('Other Listings in Building', 'contempo') . '</h4>';
        } elseif($ct_community_neighborhood_or_district == 'complex') {
            echo '<h4 class="border-bottom marB20">' . __('Other Listings in Complex', 'contempo') . '</h4>';
        } elseif($ct_community_neighborhood_or_district == 'borough') {
        	echo '<h4 class="border-bottom marB20">' . __('Other Listings in Borough', 'contempo') . '</h4>';
        } else {
        	echo '<h4 class="border-bottom marB20">' . __('Other Listings in Community', 'contempo') . '</h4>';
        }
		
		get_template_part('includes/sub-listings');

    echo '</div>';
    echo '<!-- //Sub Listings -->';
}

?>