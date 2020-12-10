<?php
/**
 * Listings Carousel
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$count = 1;
$ct_home_featured_order = isset( $ct_options['ct_home_featured_order'] ) ? $ct_options['ct_home_featured_order'] : '';
$ct_home_listing_carousel_items = isset( $ct_options['ct_home_listing_carousel_items'] ) ? esc_html( $ct_options['ct_home_listing_carousel_items'] ) : '';
$ct_home_listing_carousel_status = isset( $ct_options['ct_home_listing_carousel_status'] ) ? esc_html( $ct_options['ct_home_listing_carousel_status'] ) : '';

?>

<!-- Listings Carousel -->
<ul id="home-listings-carousel" class="owl-carousel">

    <?php

    	if($ct_home_listing_carousel_status == 'featured') {
		    if(class_exists('SitePress')) {
		    	if($ct_options['ct_home_featured_order'] == 'yes') {
			        $args = array(
			            'ct_status'			=> ct_get_taxo_translated(),
			            'post_type'			=> 'listings',
			            'meta_key'			=> '_ct_listing_home_feat_order',
			            'orderby'			=> 'meta_value_num',
	                    'order'				=> 'ASC',
	                    'posts_per_page'	=> $ct_home_listing_carousel_items,
			        );
			    } else {
			    	$args = array(
			            'ct_status'			=> ct_get_taxo_translated(),
			            'post_type'			=> 'listings',
			            'posts_per_page'	=> $ct_home_listing_carousel_items
			        );
			    }
		    } else {
		    	if($ct_options['ct_home_featured_order'] == 'yes') {
			    	$args = array(
			            'ct_status'			=> __('featured', 'contempo'),
			            'post_type'			=> 'listings',
			            'meta_key'			=> '_ct_listing_home_feat_order',
			            'orderby'   		=> 'meta_value_num',
	                    'order'     		=> 'ASC',
	                    'posts_per_page'	=> $ct_home_listing_carousel_items,
			        );
			    } else {
			    	$args = array(
			            'ct_status'			=> __('featured', 'contempo'),
			            'post_type'			=> 'listings',
			            'posts_per_page'	=> $ct_home_listing_carousel_items
			        );
			    }
		    }
		} else {
			$args = array(
	            'post_type'			=> 'listings',
                'order'     		=> 'DESC',
                'posts_per_page'	=> $ct_home_listing_carousel_items,
	        );
		}
        $wp_query = new wp_query( $args ); 
        
    if($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
        	
        	<li class="listing minimal">

		        <figure>
		        	<?php ct_status_featured(); ?>
		            <?php ct_status(); ?>
		            <?php ct_property_type_icon(); ?>
		            <?php ct_listing_actions(); ?>
	        		<?php ct_first_image_linked(); ?>
	    		</figure>
	    		<div class="grid-listing-info">
		            <header>
		                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
		                <p class="location muted marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?></p>
	                </header>
	                <p class="price marB0"><?php ct_listing_price(); ?></p>
		            <div class="propinfo">
		            	<p><?php echo ct_excerpt(); ?></p>
		                <ul class="marB0">
							<?php ct_propinfo(); ?>
	                    </ul>
	                </div>
	                <?php ct_listing_creation_date(); ?>
	                <?php ct_listing_grid_agent_info(); ?>
	                <?php ct_brokered_by(); ?>
	            </div>

	        </li>
		
	<?php $count++; endwhile; endif; wp_reset_postdata(); ?>
	
</ul>
<!-- //Listings Carousel -->