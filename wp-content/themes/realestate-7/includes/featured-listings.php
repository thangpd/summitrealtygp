<?php
/**
 * Featured Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

if(class_exists('SitePress')) {
	$lang =  ICL_LANGUAGE_CODE;
}
 
$ct_home_featured_num = isset( $ct_options['ct_home_featured_num'] ) ? $ct_options['ct_home_featured_num'] : '';
$ct_home_featured_title = isset( $ct_options['ct_home_featured_title'] ) ? $ct_options['ct_home_featured_title'] : '';
$ct_home_featured_btn = isset( $ct_options['ct_home_featured_btn'] ) ? $ct_options['ct_home_featured_btn'] : '';
$ct_home_featured_order = isset( $ct_options['ct_home_featured_order'] ) ? $ct_options['ct_home_featured_order'] : '';
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

?>

<header class="masthead">
	<?php if(!empty($ct_home_featured_title)) { ?>
		<h4 class="left marT0 marB0"><?php echo esc_html($ct_home_featured_title); ?></h4>
	<?php } ?>

	<?php if($ct_home_featured_btn == 'yes') { ?>
		<div class="right">
			<?php if(class_exists('SitePress')) { ?>
					<a class="view-all right" href="<?php echo home_url(); ?>?ct_ct_status=<?php echo strtolower(ct_get_taxo_translated()); ?>&search-listings=true"><?php esc_html_e('View All','contempo'); ?><i class="fa fa-angle-right"></i></a>
				<?php } else { ?>
					<a class="view-all right" href="<?php echo home_url(); ?>?ct_ct_status=featured&search-listings=true"><?php esc_html_e('View All','contempo'); ?><i class="fa fa-angle-right"></i></a>
			<?php } ?>
		</div>
	<?php } ?>

	<?php if($ct_home_featured_num > 3) {
		echo '<div id="featured-listings-nav" class="right marR10"></div>';
	} ?>

			<div class="clear"></div>
</header>
<ul id="owl-featured-carousel" class="owl-carousel">
    <?php

	    if(class_exists('SitePress')) {
	    	if($ct_options['ct_home_featured_order'] == 'yes') {
		        $args = array(
		            'ct_status'			=> ct_get_taxo_translated(),
		            'post_type'			=> 'listings',
		            'meta_key'			=> '_ct_listing_home_feat_order',
		            'orderby'			=> 'meta_value_num',
                    'order'				=> 'ASC',
                    'posts_per_page'	=> $ct_home_featured_num,
		        );
		    } else {
		    	$args = array(
		            'ct_status'			=> ct_get_taxo_translated(),
		            'post_type'			=> 'listings',
		            'posts_per_page'	=> $ct_home_featured_num
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
                    'posts_per_page'	=> $ct_home_featured_num,
		        );
		    } else {
		    	$args = array(
		            'ct_status'			=> __('featured', 'contempo'),
		            'post_type'			=> 'listings',
		            'posts_per_page'	=> $ct_home_featured_num
		        );
		    }
	    }
        $wp_query = new wp_query( $args ); 
        
        $count = 0;

        if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();

        $ct_cpt_brokerage = get_post_meta( $post->ID, '_ct_brokerage', true );

        ?>
         
        <li class="listing col span_12 item <?php echo esc_html($ct_search_results_listing_style); ?> <?php if(empty($ct_cpt_brokerage)) { echo 'no-brokerage'; } ?>">

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
	                <p class="location muted marB0"><?php if(function_exists('city')) { city(); } ?>, <?php if(function_exists('state')) { state(); } ?> <?php if(function_exists('zipcode')) { zipcode(); } ?><?php if(function_exists('country')) { country(); } ?></p>
                </header>
                <p class="price marB0"><?php ct_listing_price(); ?></p>
	            <div class="propinfo">
	            	<p><?php echo ct_excerpt(); ?></p>
	                <ul class="marB0">
						<?php ct_propinfo(); ?>
                    </ul>
                </div>
                <?php if($ct_search_results_listing_style == 'modern') {
	                echo '<a class="search-view-listing btn" ';
	                    ct_listing_permalink();
	                echo '>';
	                    echo '<span>' . __('View', 'contempo') . '<i class="fas fa-chevron-right"></i></span>';
	                echo '</a>';
	            } ?>
                <?php ct_listing_creation_date(); ?>
                <?php ct_listing_grid_agent_info(); ?>
                <?php ct_brokered_by(); ?>
            </div>
	
        </li>
        
        <?php
		
		endwhile; endif; wp_reset_postdata(); ?>
</ul>
    <div class="clear"></div>