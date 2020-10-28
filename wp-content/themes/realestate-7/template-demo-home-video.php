<?php
/**
 *
 * NOTE: DO NOT USE THIS TEMPLATE ITS ONLY FOR THE DEMO SITES
 *
 *
 * Template Name: Demo Home Video
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 *
 *
 */
 
if (!empty($_GET['search-listings'])) {
	require('search-listings.php');
	return;
}

$ct_home_adv_search_style = isset( $ct_options['ct_home_adv_search_style'] ) ? $ct_options['ct_home_adv_search_style'] : '';
$ct_cta = isset( $ct_options['ct_cta'] ) ? $ct_options['ct_cta'] : '';
$ct_cta_bg_img = isset( $ct_options['ct_cta_bg_img']['url'] ) ? esc_url( $ct_options['ct_cta_bg_img']['url'] ) : '';
$ct_cta_bg_color = isset( $ct_options['ct_cta_bg_color'] ) ? esc_html( $ct_options['ct_cta_bg_color'] ) : '';
$ct_hero_search_bg_video_placeholder = isset( $ct_options['ct_hero_search_bg_video_placeholder']['url'] ) ? esc_html( $ct_options['ct_hero_search_bg_video_placeholder']['url'] ) : '';
$ct_hero_search_bg_video = isset( $ct_options['ct_hero_search_bg_video']['url'] ) ? esc_html( $ct_options['ct_hero_search_bg_video']['url'] ) : '';

get_header();

	        echo '<!-- Hero Search -->';
	        echo '<style type="text/css">';
	        	echo '#header-search-wrap { display: none;}';
	        echo '</style>';
        	echo '<section class="hero-search">';
	        		if($ct_hero_search_bg_video != '') {
		        		echo '<video poster="' . $ct_hero_search_bg_video_placeholder . '" id="bgvid" playsinline autoplay muted loop>';
							echo '<source src="' . $ct_hero_search_bg_video . '" type="video/mp4">';
						echo '</video>';
					}
					echo '<h1>Find your new home</h1>';
					echo '<h2>Its just a few clicks away.</h2>';
					get_template_part('/includes/home-hero-advanced-search');
			echo'</section>';
			echo '<!-- //Hero Search -->';
			echo '<div class="clear"></div>';

	        $ct_home_page_builder_id = isset( $ct_options['ct_home_page_builder_id'] ) ? esc_attr( $ct_options['ct_home_page_builder_id'] ) : '';
	         	
	     	echo '<!-- Page Builder -->';
	        echo '<section class="page-builder ' . esc_html($ct_home_page_builder_id) . '">';
	            echo '<div class="container">';
						$args = array(
							'post_type' => 'page',
							'post__in' => array($ct_home_page_builder_id)
						);
						$query = new WP_Query( $args );
						while ($query -> have_posts()) : $query -> the_post();
							the_content();
						endwhile; wp_reset_postdata();
	            echo'</div>';
				echo'<div class="clear"></div>';
	        echo'</section>';
	        echo '<!-- //Page Builder -->';

	        // Call To Action

	        echo '<!-- Call To Action -->';
	        // Custom CTA Background Image
			if(!empty($ct_cta_bg_img)) {
				echo'<style type="text/css">';
				echo '.cta { background: url(';
				echo esc_url($ct_cta_bg_img);
				echo ') no-repeat center center; background-size: cover;}';
				echo '</style>';
			} elseif(!empty($ct_cta_bg_color)) {
		        echo'<style type="text/css">';
		        echo '.dark-overlay { background: none;} ';
		        echo '.cta { background-color:';
		        echo esc_html($ct_cta_bg_color);
		        echo '}';
		        echo '</style>';
		    }    

			echo '<section class="cta center">';
				echo '<div class="dark-overlay">';
					echo '<div class="container">';
						echo stripslashes($ct_cta);
					echo'</div>';
				echo'</div>';
			echo'</section>';
			echo '<!-- //Call To Action -->';

			// Featured Listings

			echo '<!-- Featured Listings -->';
			echo '<section class="featured-listings">';
				echo '<div class="container">';
					get_template_part('/includes/featured-listings');
				echo'</div>';
			echo'</section>';
			echo '<!-- //Featured Listings -->';
			echo '<div class="clear"></div>';

	        // Testimonials

			echo '<!-- Testimonials -->';
			echo '<section class="testimonials">';
				echo '<div class="container">';
					get_template_part('/includes/testimonials');
				echo'</div>';
			echo'</section>';
			echo '<!-- //Testimonials -->';
			echo '<div class="clear"></div>';

	        // Partners

			echo '<!-- Partners -->';
			echo '<section class="partners">';
				echo '<div class="container">';
					get_template_part('/includes/partners');
				echo'</div>';
			echo'</section>';
			echo '<!-- //Partners -->';
			echo '<div class="clear"></div>';
				
get_footer(); ?>