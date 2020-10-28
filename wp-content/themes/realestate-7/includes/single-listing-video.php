<?php
/**
 * Single Listing Video
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';

do_action('before_single_listing_video');

$ct_source = get_post_meta($post->ID, 'source', true);
            
$ct_video_url = get_post_meta($post->ID, "_ct_video", true);
$ct_embed_code = wp_oembed_get( $ct_video_url );

if(!empty($ct_video_url) && strpos($ct_video_url, 'http://') !== 0) {
	
	echo '<!-- Video -->';
	echo '<div id="listing-video" class="videoplayer">';
		if($ct_single_listing_content_layout_type == 'accordion') {
			echo '<h4 id="listing-video-heading" class="info-toggle border-bottom marB18">' . __('Video', 'contempo') . '</h4>';
		} else {
			echo '<h4 id="listing-video-heading" class="border-bottom marB18">' . __('Video', 'contempo') . '</h4>';
		}

		echo '<div class="info-inner">';
			if($ct_source == 'idx-api') {
				echo '<div class="fluid-width-video-wrapper" style="padding-top: 56.25%;">';
					echo '<iframe src="' . esc_url($ct_video_url) . '"></iframe>';
				echo '</div>';
			} else {
	        	print($ct_embed_code);
			}
		echo '</div>';
		
	echo '</div>';
	echo '<!-- //Video -->';
}

?>