<?php
/**
 * Listings Count
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$layout = isset( $ct_options['ct_listings_count_layout']['enabled'] ) ? $ct_options['ct_listings_count_layout']['enabled'] : '';

?>

<!-- Listings Count -->
<ul>
	<?php

	if ($layout) :
	    
	    foreach ($layout as $key=>$value) {
	    
	        switch($key) {

	        // Total For Sale
	        case 'total_for_sale' :   

			echo '<li class="listing-total-count col span_3">';
				echo '<a href="'. home_url() . '/?ct_ct_status=for-sale&search-listings=true">';
					echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'for-sale'
						        )
						    )
						);
						$query = new WP_Query( $args );

						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('Homes For Sale', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

			break;

			// Open Houses
	        case 'open_houses' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=open-house&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'open-house'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('Open Houses', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;

		    // Sold
	        case 'sold' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=sold&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'sold'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('Recently Sold', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;

		    // Reduced
	        case 'price_reduced' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=reduced&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'reduced'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('Reduced', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;

		    // For Rent
	        case 'for_rent' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=for-rent&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'for-rent'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('For Rent', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;

		    // Leased
	        case 'leased' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=leased&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'leased'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('Leased', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;

		    // Featured
	        case 'featured' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=featured&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'featured'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('Featured', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;

		    // New Additions
	        case 'new_additions' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=new-addition&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'new-addition'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('New Additions', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;

		    // Special Offer
	        case 'special_offer' :

		    echo '<li class="listing-total-count col span_3">';
			    echo '<a href="' . home_url() . '/?ct_ct_status=special-offer&search-listings=true">';
			    	echo '<h3 class="marT0 marB0">';
				    	$args = array(
						  'post_type' => 'listings',
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field' => 'slug',
						            'terms' => 'special-offer'
						        )
						    )
						);
						$query = new WP_Query( $args );
						echo esc_html($query->found_posts);
						wp_reset_postdata();
			    	echo '</h3>';
			    	echo '<h5 class="marB0 muted">' . __('Special Offers', 'contempo') . '</h5>';
		    	echo '</a>';
		    echo '</li>';

		    break;
			
	        }
	    
	    } endif; 

		echo '<div class="clear"></div>';

	?>
</ul>
<!-- //Listings Count -->