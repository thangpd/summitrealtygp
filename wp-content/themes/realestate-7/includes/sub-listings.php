<?php
/**
 * Related sub listings dependant on tagged community for single-listings.php
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

wp_reset_postdata();

?>

<ul>
    <?php
    global $post;

    $terms = strip_tags( get_the_term_list( $wp_query->post->ID, 'community', '', ', ', '' ) );

	$args = array(
		'post_type' => 'listings',
		'post__not_in' => array($post->ID),
		'showposts'=> 3,
		'tax_query' => array(
			array(
				'taxonomy' => 'community',
				'field'    => 'slug',
				'terms'    => $terms,
			),
		)
	);
	$query = new WP_Query( $args );

	if( $query->have_posts() ) {

	$count = 0; while ($query->have_posts()) : $query->the_post(); ?>
            
        <li class="listing col span_4 <?php echo esc_html($ct_search_results_listing_style); ?> <?php if($count % 3 == 0) { echo 'first'; } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">

        		<?php //if(has_post_thumbnail()) { ?>
	            <figure>
	                <?php
		                $status_tags = strip_tags( get_modified_term_list_name( $query->post->ID, 'ct_status', '', ' ', '', array('featured') ) );
						if($status_tags != '') {
							echo '<h6 class="snipe status ';
									$status_terms = get_the_terms( $query->post->ID, 'ct_status', array() );
									if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
									     foreach ( $status_terms as $term ) {
									       echo esc_html($term->slug) . ' ';
									     }
									 }
								echo '">';
								echo '<span>';
									echo esc_html($status_tags);
								echo '</span>';
							echo '</h6>';
						}
	                ?>
	                <?php ct_first_image_linked(); ?>
	            </figure>
	            <?php //} ?>
	            <div class="grid-listing-info">
		            <header>
		                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
		                <?php
			            	if(taxonomy_exists('city')){
				                $city = strip_tags( get_the_term_list( $query->post->ID, 'city', '', ', ', '' ) );
				            }
				            if(taxonomy_exists('state')){
								$state = strip_tags( get_the_term_list( $query->post->ID, 'state', '', ', ', '' ) );
							}
							if(taxonomy_exists('zipcode')){
								$zipcode = strip_tags( get_the_term_list( $query->post->ID, 'zipcode', '', ', ', '' ) );
							}
							if(taxonomy_exists('country')){
								$country = strip_tags( get_the_term_list( $query->post->ID, 'country', '', ', ', '' ) );
							}
						?>
		                <p class="location marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
	                </header>
	                <p class="price marB0"><?php ct_listing_price(); ?></p>
		            <div class="propinfo">
		                <ul class="marB0 marL0">
							<?php ct_propinfo(); ?>
	                    </ul>
	                </div>
	                <?php ct_listing_creation_date(); ?>
	                <?php ct_listing_grid_agent_info(); ?>
	                	<div class="clear"></div>
	                <?php ct_brokered_by(); ?>
	            </div>
	
        </li>
        
        <?php
		
		$count++;
		
		if($count % 3 == 0) {
			echo '<div class="clear"></div>';
		}
		
		endwhile; wp_reset_postdata();
	} ?>
</ul>
    <div class="clear"></div>