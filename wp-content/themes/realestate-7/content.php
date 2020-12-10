<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;

$ct_post_archive_layout = isset( $ct_options['ct_post_archive_layout'] ) ? $ct_options['ct_post_archive_layout'] : '';

if(is_single()) {

	echo '<!-- Post Content -->';
	echo '<article class="single-inner">';
		
		// Post Content
		echo '<div class="inner-content">';

			the_content();
		
		echo '</div>';
	echo '<!-- //Post Content -->';

} elseif($ct_post_archive_layout == 'grid') {

    get_template_part('layouts/blog-grid');

} else {

    get_template_part('layouts/blog-large');

}

//wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>    