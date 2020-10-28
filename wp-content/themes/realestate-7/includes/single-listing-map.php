<?php
/**
 * Single Listing Map
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';

$ct_driving_directions = isset( $ct_options['ct_driving_directions'] ) ? esc_html( $ct_options['ct_driving_directions'] ) : '';
$ct_latlng = get_post_meta(get_the_ID(), '_ct_latlng', true);

do_action('before_single_listing_map');
            
echo '<!-- Map -->';
echo '<div id="listing-location">';

	if($ct_single_listing_content_layout_type == 'accordion') {
	    echo '<h4 id="listing-map-heading" class="info-toggle border-bottom marB18">' . __('Location', 'contempo') . '</h4>';
	} else {
		echo '<h4 id="listing-map-heading" class="border-bottom marB18">' . __('Location', 'contempo') . '</h4>';
	}

	echo '<div class="info-inner">';

	    ct_listing_map();

	    /* Driving Directions */
	    if($ct_driving_directions != 'yes') {

		    echo '<form id="get-directions" action="https://maps.google.com/maps" method="get" target="_blank">';
		    	echo '<div class="col span_9 first">';
					echo '<input type="text" name="saddr" data-type="google-autocomplete" placeholder="' . __('Enter your starting address', 'contempo') . '" autocomplete="off" />';
					echo '<input type="hidden" name="daddr" value="';
						if(!empty($ct_latlng)) {
							echo esc_html($ct_latlng);
						} else {
							the_title();
							echo ' ';
							ct_taxonomy('city');
							echo ' ';
							ct_taxonomy('state');
							echo ' ';
							ct_taxonomy('zipcode');
						}
					echo '" />';
				echo '</div>';
				echo '<div class="col span_3">';
					echo '<input type="submit" value="' . __('get directions', 'contempo') . '" />';
				echo '</div>';
					echo '<div class="clear"></div>';
			echo '</form>';
		}
		
	echo '</div>';

echo '</div>';
echo '<!-- //Map -->';

/* Auto Complete for Driving Directions */
if($ct_driving_directions != 'yes') { ?>
	<script>
		jQuery(function() {
			function initAutocomplete() {
				var input = document.querySelector('[data-type=google-autocomplete]');
				var autocomplete = new google.maps.places.Autocomplete(
			      input,
			      { types: ['geocode'] }
				);
			  
				setTimeout(function(){ 
					jQuery(".pac-container").prependTo(input);
				}, 300); 
			}
			initAutocomplete();
		});
	</script>
<?php } 
?>