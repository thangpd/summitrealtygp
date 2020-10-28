<?php
/**
 * Single Listing Features
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';

do_action('before_single_listing_featlist');

$ct_source = get_post_meta($post->ID, 'source', true);

//if($ct_source != 'idx-api') {
	echo '<!-- Feature List -->';
	$ct_additional_features = get_the_terms($post->ID, 'additional_features');
	if($ct_additional_features) {
	    echo '<div id="listing-features">';
		    if($ct_single_listing_content_layout_type == 'accordion') {
				echo '<h4 id="listing-prop-features" class="info-toggle border-bottom marB20">' . __('Property Features', 'contempo') . '</h4>';
			} else {
				echo '<h4 id="listing-prop-features" class="border-bottom marB20">' . __('Property Features', 'contempo') . '</h4>';
			}
			echo '<div class="info-inner">';
				echo '<ul class="propfeatures col span_6">';
				$count = 0;
				foreach ($ct_additional_features as $taxindex => $taxitem) {
					echo '<li><i class="fa fa-check"></i>' . $taxitem->name . '</li>';
					$count++;
					if ($count == 6) {
						echo '</ul><ul class="propfeatures col span_6">';
						$count = 0;
					}
				}
				echo '</ul>';
				echo '<div class="clear"></div>';
			echo '</div>';
	    echo '</div>';
	}
	echo '<!-- //Feature List -->';
//}

?>