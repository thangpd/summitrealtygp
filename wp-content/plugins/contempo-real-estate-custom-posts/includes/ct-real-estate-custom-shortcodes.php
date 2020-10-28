<?php

/**
 * Register Custom Shortcodes
 *
 * @link       http://contempographicdesign.com
 * @since      1.0.0
 *
 * @package    Contempo Real Estate Custom Posts
 * @subpackage ct-real-estate-custom-posts/includes
 */

/*-----------------------------------------------------------------------------------*/
/* Listings Shortcode */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listings_shortcode')) {
	function ct_listings_shortcode( $atts ) {

		// Attributes
		extract( shortcode_atts(
			array(
				'layout' => 'grid',
				'orderby' => '',
				'order' => '',
				'meta_key' => '',
				'meta_type' => '',
				'number' => '',
				'sold' => '',
				'type' => '',
				'beds' => '',
				'baths' => '',
				'status' => '',
				'city' => '',
				'state' => '',
				'zipcode' => '',
				'country' => '',
				'county' => '',
				'community' => '',
				'additional_features' => ''
			), $atts )
		);

		// Output
		echo '<ul class="col span_12 row first">';

			global $post;
			global $ct_options;

			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

	    	if($meta_key == "_ct_price") {
				$ct_price = get_post_meta($post->ID, "_ct_price", true);
				$args = array(
       				'ct_status' => $status,
		            'property_type' => $type,
        			'beds' => $beds,
		            'baths' => $baths,
        			'city' => $city,
		            'state' => $state,
        			'zipcode' => $zipcode,
        			'country' => $country,
        			'county' => $county,
        			'community' => $community,
        			'additional_features' => $additional_features,
        			'post_type' => 'listings',
		            'orderby' => 'meta_value',
					'meta_key' => '_ct_price',
					'meta_type' => 'numeric',
					'tax_query' => array(
				        array(
				            'taxonomy' => 'ct_status',
				            'field'     => 'slug',
						    'terms'     => $sold,
				            'operator' => 'NOT IN'
				        )
				    ),
					'order' => $order,
					'paged' => $paged,
		            'posts_per_page' => $number
    			);
			} else {
				$args = array(
        			'ct_status' => $status,
        			'property_type' => $type,
        			'beds' => $beds,
        			'baths' => $baths,
        			'city' => $city,
        			'state' => $state,
        			'zipcode' => $zipcode,
        			'country' => $country,
        			'county' => $county,
        			'community' => $community,
        			'additional_features' => $additional_features,
        			'post_type' => 'listings',
        			'orderby' => $orderby,
					'order' => $order,
					'meta_key' => $meta_key,
					'meta_type' => 'numeric',
					'tax_query' => array(
				        array(
				            'taxonomy' => 'ct_status',
				            'field'     => 'slug',
						    'terms'     => $sold,
				            'operator' => 'NOT IN'
				        )
				    ),
				    'paged' => $paged,
        			'posts_per_page' => $number
    			);
			}
		    $wp_query = new wp_query( $args );
	        
	        $count = 0;
	        if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();

	        if(taxonomy_exists('city')){
		        $city = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
		    }
		    if(taxonomy_exists('state')){
		        $state = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
		    }
		    if(taxonomy_exists('zipcode')){
		        $zipcode = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );
		    }
		    if(taxonomy_exists('country')){
		        $country = strip_tags( get_the_term_list( $wp_query->post->ID, 'country', '', ', ', '' ) );
		    }
		    if(taxonomy_exists('county')){
		        $county = strip_tags( get_the_term_list( $wp_query->post->ID, 'county', '', ', ', '' ) );
		    }

	        $beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
		    $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

		    $ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';
			$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
			$ct_listing_stats_on_off = isset( $ct_options['ct_listing_stats_on_off'] ) ? esc_attr( $ct_options['ct_listing_stats_on_off'] ) : '';

			$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
		    
		    $ct_walkscore = isset( $ct_options['ct_enable_walkscore'] ) ? esc_html( $ct_options['ct_enable_walkscore'] ) : '';
		    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
		    $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

		    if($ct_walkscore == 'yes') {
			    /* Walk Score */
			   	$latlong = get_post_meta($post->ID, "_ct_latlng", true);
			   	if($latlong != '') {
					list($lat, $long) = explode(',',$latlong,2);
					$address = get_the_title() . ct_taxonomy_return('city') . ct_taxonomy_return('state') . ct_taxonomy_return('zipcode');
					$json = ct_get_walkscore($lat,$long,$address);

					$ct_ws = json_decode($json);
				}
			}

	        ?>

	        <?php if($layout == 'List') { ?>

	        	<li class="listing listing-list col span_12 first">

			        <?php do_action('before_listing_list_img'); ?>

			        <?php if(has_post_thumbnail()) { ?>
			        <figure class="col span_6 first">
			        	<?php
		           			if(has_term( 'featured', 'ct_status' ) ) {
								echo '<h6 class="snipe featured">';
									echo '<span>';
										echo __('Featured', '');
									echo '</span>';
								echo '</h6>';
							}
						?>
			            <?php

			                $status_tags = strip_tags( get_modified_term_list_name( $wp_query->post->ID, 'ct_status', '', ' ', '', array('featured') ) );
							if($status_tags != '') {
								echo '<h6 class="snipe status ';
										$status_terms = strip_tags( get_modified_term_list_slug( $wp_query->post->ID, 'ct_status', '', ' ', '', array('featured') ) );
										if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
										     echo esc_html($status_terms) . ' ';
										 }
									echo '">';
									echo '<span>';
										echo esc_html($status_tags);
									echo '</span>';
								echo '</h6>';
							}
		                ?>
		                <?php if( function_exists('ct_property_type_icon') ) {
		                	ct_property_type_icon();
		            	}

							echo '<ul class="listing-actions">';

								// Count Total images
						        $attachments = get_children(
						            array(
						                'post_type' => 'attachment',
						                'post_mime_type' => 'image',
						                'post_parent' => get_the_ID()
						            )
						        );

						        $img_count = count($attachments);

						        $feat_img = 1;
						        $total_imgs = $img_count + $feat_img;

								echo '<li>';
									echo '<span class="listing-views" data-tooltip="' . $img_count . __(' Photos','contempo') . '">';
										echo '<i class="fa fa-image"></i>';
									echo '</span>';
								echo '</li>';
								
								if (function_exists('wpfp_link')) {
									echo '<li>';
										echo '<span class="save-this" data-tooltip="' . __('Favorite','contempo') . '">';
											wpfp_link();
										echo '</span>';
									echo '</li>';
								}

								if(class_exists('Redq_Alike')) {
									echo '<li>';
										echo '<span class="compare-this" data-tooltip="' . __('Compare','contempo') . '">';
											echo do_shortcode('[alike_link vlaue="compare" show_icon="true" icon_class="fa fa-plus-square-o"]');
										echo '</span>';
									echo '</li>';
								}

								if(function_exists('ct_get_listing_views') && $ct_listing_stats_on_off != 'no') {
									echo '<li>';
										echo '<span class="listing-views" data-tooltip="' . ct_get_listing_views(get_the_ID()) . __(' Views','contempo') . '">';
											echo '<i class="fa fa-bar-chart"></i>';
										echo '</span>';
									echo '</li>';
								}

							echo '</ul>';
						?>
		                <?php if( function_exists('ct_first_image_linked') ) {
		                	ct_first_image_linked();
		                } ?>
			        </figure>
			        <?php } ?>

			        <?php do_action('before_listing_list_info'); ?>

			        <div class="list-listing-info col span_6">
			            <div class="list-listing-info-inner">
			                <header>
				                <h5 class="marB0"><a href="<?php the_permalink(); ?>"><?php if( function_exists('ct_listing_title') ) { ct_listing_title(); } ?></a></h5>
				                <p class="location muted marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
			                </header>
			                <p class="price marB0"><?php if( function_exists('ct_listing_price') ) { ct_listing_price(); } ?></p>
			                
			                <div class="propinfo">
				                <p class="propinfo-excerpt"><?php if( function_exists('ct_excerpt') ) { echo ct_excerpt(25); } ?></p>
				                <ul class="marB0">
									<?php

								    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) { 
								        // Dont Display Bed/Bath
								    } else {
								    	if(!empty($beds)) {
									    	echo '<li class="row beds">';
									    		echo '<span class="muted left">';
									    			if($ct_use_propinfo_icons != 'icons') {
										    			_e('Bed', 'contempo');
										    		} else {
										    			echo '<i class="fa fa-bed"></i>';
										    		}
									    		echo '</span>';
									    		echo '<span class="right">';
									               echo $beds;
									            echo '</span>';
									        echo '</li>';
									    }	
									    if(!empty($baths)) {
									        echo '<li class="row baths">';
									            echo '<span class="muted left">';
									    			if($ct_use_propinfo_icons != 'icons') {
										    			_e('Baths', 'contempo');
										    		} else {
										    			echo '<i class="fa fa-bath"></i>';
										    		}
									    		echo '</span>';
									    		echo '<span class="right">';
									               echo $baths;
									            echo '</span>';
									        echo '</li>';
									    }
								    }

								    if($ct_walkscore == 'yes') {
									    if(!empty($ct_ws->walkscore)) {
										    echo '<li class="row walkscore">';
												echo '<span class="muted left">';
													_e('Walk Score&reg;', 'contempo');
												echo '</span>';
												echo '<span class="right">';
													echo '<a class="tooltips" href=" ' . $ct_ws->ws_link , '" target="_blank">';
												        echo $ct_ws->walkscore;
												        echo '<span>' . $ct_ws->description. '</span>';
											        echo '</a>';
										        echo '</span>';
										    echo '</li>';
										}
									}

									include_once ABSPATH . 'wp-admin/includes/plugin.php';
									if($ct_listing_reviews == 'yes' || is_plugin_active('comments-ratings/comments-ratings.php')) {
										global $pixreviews_plugin;
										$ct_rating_avg = $pixreviews_plugin->get_average_rating();
										if($ct_rating_avg != '') {
											echo '<li class="row rating">';
									            echo '<span class="muted left">';
									                if($ct_use_propinfo_icons != 'icons') {
										    			_e('Rating', 'contempo');
										    		} else {
										    			echo '<i class="fa fa-star"></i>';
										    		}
									            echo '</span>';
									            echo '<span class="right">';
									                 echo $pixreviews_plugin->get_average_rating();
									            echo '</span>';
									        echo '</li>';
									    }
									}

								    include_once ABSPATH . 'wp-admin/includes/plugin.php';
									if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {
									    if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
									        echo '<li class="row guests">';
									            echo '<span class="muted left">';
									                if($ct_use_propinfo_icons != 'icons') {
										    			_e('Guests', 'contempo');
										    		} else {
										    			echo '<i class="fa fa-group"></i>';
										    		}
									            echo '</span>';
									            echo '<span class="right">';
									                 echo get_post_meta($post->ID, "_ct_rental_guests", true);
									            echo '</span>';
									        echo '</li>';
									    }

									    if(get_post_meta($post->ID, "_ct_rental_min_stay", true)) {
									        echo '<li class="row min-stay">';
									            echo '<span class="muted left">';
									                if($ct_use_propinfo_icons != 'icons') {
										    			_e('Min Stay', 'contempo');
										    		} else {
										    			echo '<i class="fa fa-calendar"></i>';
										    		}
									            echo '</span>';
									            echo '<span class="right">';
									                 echo get_post_meta($post->ID, "_ct_rental_min_stay", true);
									            echo '</span>';
									        echo '</li>';
									    }
									}
								    
								    if(get_post_meta($post->ID, "_ct_sqft", true)) {
								    	if($ct_use_propinfo_icons != 'icons') {
									        echo '<li class="row sqft">';
									            echo '<span class="muted left">';
									    			ct_sqftsqm();
									    		echo '</span>';
									    		echo '<span class="right">';
									                 echo get_post_meta($post->ID, "_ct_sqft", true);
									            echo '</span>';
									        echo '</li>';
									    } else {
									    	echo '<li class="row sqft">';
									            echo '<span class="muted left">';
													ct_listing_size_icon();
									    		echo '</span>';
									    		echo '<span class="right">';
									                 echo get_post_meta($post->ID, "_ct_sqft", true);
									                 echo ' ' . ct_sqftsqm();
									            echo '</span>';
									        echo '</li>';
									    }
								    }
								    
								    if(get_post_meta($post->ID, "_ct_lotsize", true)) {
								        if(get_post_meta($post->ID, "_ct_sqft", true)) {
								            echo '<li class="row lotsize">';
								        }
								            echo '<span class="muted left">';
								    			if($ct_use_propinfo_icons != 'icons') {
									    			_e('Lot Size', 'contempo');
									    		} else {
									    			echo '<i class="fa fa-arrows-alt"></i>';
									    		}
								    		echo '</span>';
								    		echo '<span class="right">';
								                 echo get_post_meta($post->ID, "_ct_lotsize", true) . ' ';
								                 ct_acres();
								            echo '</span>';
								            
								        if((get_post_meta($post->ID, "_ct_sqft", true))) {
								            echo '</li>';
								        }
								    } ?>
			                    </ul>
			                </div>

			                <?php ct_brokered_by(); ?>
			            </div>
			        </div>
				
			    </li>

	        <?php } else { ?>
	            
		        <li class="listing col span_4 <?php echo $ct_search_results_listing_style; ?> <?php if($count % 3 == 0) { echo 'first'; } ?>">
		            <figure>
		            	<?php
		           			if(has_term( 'featured', 'ct_status' ) ) {
								echo '<h6 class="snipe featured">';
									echo '<span>';
										echo __('Featured', '');
									echo '</span>';
								echo '</h6>';
							}
						?>
		                <?php							
			                $status_tags = strip_tags( get_modified_term_list_name( $wp_query->post->ID, 'ct_status', '', ' ', '', array('featured') ) );
							if($status_tags != '') {
								echo '<h6 class="snipe status ';
										$status_terms = strip_tags( get_modified_term_list_slug( $wp_query->post->ID, 'ct_status', '', ' ', '', array('featured') ) );
										if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
										     echo esc_html($status_terms) . ' ';
										 }
									echo '">';
									echo '<span>';
										echo esc_html($status_tags);
									echo '</span>';
								echo '</h6>';
							}
		                ?>
		                <?php if( function_exists('ct_property_type_icon') ) {
		                	ct_property_type_icon();
		            	} ?>
		                <?php
							echo '<ul class="listing-actions">';

								// Count Total images
						        $attachments = get_children(
						            array(
						                'post_type' => 'attachment',
						                'post_mime_type' => 'image',
						                'post_parent' => get_the_ID()
						            )
						        );

						        $img_count = count($attachments);

						        $feat_img = 1;
						        $total_imgs = $img_count + $feat_img;

								echo '<li>';
									echo '<span class="listing-views" data-tooltip="' . $img_count . __(' Photos','contempo') . '">';
										echo '<i class="fa fa-image"></i>';
									echo '</span>';
								echo '</li>';
								
								if (function_exists('wpfp_link')) {
									echo '<li>';
										echo '<span class="save-this" data-tooltip="' . __('Favorite','contempo') . '">';
											wpfp_link();
										echo '</span>';
									echo '</li>';
								}

								if(class_exists('Redq_Alike')) {
									echo '<li>';
										echo '<span class="compare-this" data-tooltip="' . __('Compare','contempo') . '">';
											echo do_shortcode('[alike_link vlaue="compare" show_icon="true" icon_class="fa fa-plus-square-o"]');
										echo '</span>';
									echo '</li>';
								}

								if(function_exists('ct_get_listing_views') && $ct_listing_stats_on_off != 'no') {
									echo '<li>';
										echo '<span class="listing-views" data-tooltip="' . ct_get_listing_views(get_the_ID()) . __(' Views','contempo') . '">';
											echo '<i class="fa fa-bar-chart"></i>';
										echo '</span>';
									echo '</li>';
								}

							echo '</ul>';
						?>
		                <?php if( function_exists('ct_first_image_linked') ) {
		                	ct_first_image_linked();
		                } ?>
		            </figure>
		            <div class="grid-listing-info">
			            <header>
			                <h5 class="marB0"><a href="<?php the_permalink(); ?>"><?php if( function_exists('ct_listing_title') ) { ct_listing_title(); } ?></a></h5>
			                <p class="location muted marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
		                </header>
		                <p class="price marB0"><?php if( function_exists('ct_listing_price') ) { ct_listing_price(); } ?></p>
			            <div class="propinfo">
			            	<p><?php if( function_exists('ct_excerpt') ) { echo ct_excerpt(25); } ?></p>
			                <ul class="marB0">
								<?php

							    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) { 
							        // Dont Display Bed/Bath
							    } else {
							    	if(!empty($beds)) {
								    	echo '<li class="row beds">';
								    		echo '<span class="muted left">';
								    			if($ct_use_propinfo_icons != 'icons') {
									    			_e('Bed', 'contempo');
									    		} else {
									    			echo '<i class="fa fa-bed"></i>';
									    		}
								    		echo '</span>';
								    		echo '<span class="right">';
								               echo $beds;
								            echo '</span>';
								        echo '</li>';
								    }	
								    if(!empty($baths)) {
								        echo '<li class="row baths">';
								            echo '<span class="muted left">';
								    			if($ct_use_propinfo_icons != 'icons') {
									    			_e('Baths', 'contempo');
									    		} else {
									    			echo '<i class="fa fa-bath"></i>';
									    		}
								    		echo '</span>';
								    		echo '<span class="right">';
								               echo $baths;
								            echo '</span>';
								        echo '</li>';
								    }
							    }

							    if($ct_walkscore == 'yes') {
								    if(!empty($ct_ws->walkscore)) {
									    echo '<li class="row walkscore">';
											echo '<span class="muted left">';
												_e('Walk Score&reg;', 'contempo');
											echo '</span>';
											echo '<span class="right">';
												echo '<a class="tooltips" href=" ' . $ct_ws->ws_link , '" target="_blank">';
											        echo $ct_ws->walkscore;
											        echo '<span>' . $ct_ws->description. '</span>';
										        echo '</a>';
									        echo '</span>';
									    echo '</li>';
									}
								}

								include_once ABSPATH . 'wp-admin/includes/plugin.php';
								if($ct_listing_reviews == 'yes' || is_plugin_active('comments-ratings/comments-ratings.php')) {
									global $pixreviews_plugin;
									$ct_rating_avg = $pixreviews_plugin->get_average_rating();
									if($ct_rating_avg != '') {
										echo '<li class="row rating">';
								            echo '<span class="muted left">';
								                if($ct_use_propinfo_icons != 'icons') {
									    			_e('Rating', 'contempo');
									    		} else {
									    			echo '<i class="fa fa-star"></i>';
									    		}
								            echo '</span>';
								            echo '<span class="right">';
								                 echo $pixreviews_plugin->get_average_rating();
								            echo '</span>';
								        echo '</li>';
								    }
								}

							    include_once ABSPATH . 'wp-admin/includes/plugin.php';
								if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {
								    if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
								        echo '<li class="row guests">';
								            echo '<span class="muted left">';
								                if($ct_use_propinfo_icons != 'icons') {
									    			_e('Guests', 'contempo');
									    		} else {
									    			echo '<i class="fa fa-group"></i>';
									    		}
								            echo '</span>';
								            echo '<span class="right">';
								                 echo get_post_meta($post->ID, "_ct_rental_guests", true);
								            echo '</span>';
								        echo '</li>';
								    }

								    if(get_post_meta($post->ID, "_ct_rental_min_stay", true)) {
								        echo '<li class="row min-stay">';
								            echo '<span class="muted left">';
								                if($ct_use_propinfo_icons != 'icons') {
									    			_e('Min Stay', 'contempo');
									    		} else {
									    			echo '<i class="fa fa-calendar"></i>';
									    		}
								            echo '</span>';
								            echo '<span class="right">';
								                 echo get_post_meta($post->ID, "_ct_rental_min_stay", true);
								            echo '</span>';
								        echo '</li>';
								    }
								}
							    
							    if(get_post_meta($post->ID, "_ct_sqft", true)) {
							    	if($ct_use_propinfo_icons != 'icons') {
								        echo '<li class="row sqft">';
								            echo '<span class="muted left">';
								    			ct_sqftsqm();
								    		echo '</span>';
								    		echo '<span class="right">';
								                 echo get_post_meta($post->ID, "_ct_sqft", true);
								            echo '</span>';
								        echo '</li>';
								    } else {
								    	echo '<li class="row sqft">';
								            echo '<span class="muted left">';
												ct_listing_size_icon();
								    		echo '</span>';
								    		echo '<span class="right">';
								                 echo get_post_meta($post->ID, "_ct_sqft", true);
								                 echo ' ' . ct_sqftsqm();
								            echo '</span>';
								        echo '</li>';
								    }
							    }
							    
							    if(get_post_meta($post->ID, "_ct_lotsize", true)) {
							        if(get_post_meta($post->ID, "_ct_sqft", true)) {
							            echo '<li class="row lotsize">';
							        }
							            echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Lot Size', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-arrows-alt"></i>';
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_lotsize", true) . ' ';
							                 ct_acres();
							            echo '</span>';
							            
							        if((get_post_meta($post->ID, "_ct_sqft", true))) {
							            echo '</li>';
							        }
							    } ?>
		                    </ul>
		                </div>

		                <?php if($ct_search_results_listing_style == 'modern') {
			                echo '<a class="search-view-listing btn" ';
			                    ct_listing_permalink();
			                echo '>';
			                    echo '<span>' . __('View', 'contempo') . '<i class="fa fa-chevron-right"></i></span>';
			                echo '</a>';
			            } ?>

			            <?php ct_upcoming_open_house(); ?>
			            <?php ct_listing_creation_date(); ?>

		            </div>
			
		        </li>

		    <?php } ?>

			<?php
			
			$count++;
			
			if($count % 3 == 0) {
				echo '<div class="clear"></div>';
			}
			
			endwhile; 
			//echo '<hr>';
			$GLOBALS['wp_query']->max_num_pages = $wp_query->max_num_pages;	
			ct_numeric_pagination_local();
	
			
			endif;
			wp_reset_query();
			wp_reset_postdata();
			
		echo '</ul>';
	
		    echo '<div class="clear"></div>';
		
	}
}

/* CT Listings Module Pagination */

function ct_numeric_pagination_local() {

	global $wp_query;
	
	/* Stop execution if there's only 1 page */
	if($wp_query->max_num_pages <= 1)
		return;

	$paged = get_query_var('paged') ? absint( get_query_var('paged')) : 1;
	$max   = intval($wp_query->max_num_pages);

	/*	Add current page to the array */
	if($paged >= 1)
		$links[] = $paged;

	/*	Add the pages around the current page to the array */
	if($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if(($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="pagination"><ul>' . "\n";

	/*	Previous Post Link */
	if(get_previous_posts_link())
		printf('<li>%s</li>' . "\n", get_previous_posts_link());

	/**	Link to first page, plus ellipses if necessary */
	if(!in_array( 1, $links)) {
		$class = 1 == $paged ? ' class="current"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link(1)), '1');

		if(!in_array(2, $links))
			echo '<li>…</li>';
	}

	/*	Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach((array) $links as $link) {
		$class = $paged == $link ? ' class="current"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link($link)), $link);
	}

	/*	Link to last page, plus ellipses if necessary */
	if(!in_array($max, $links)) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>&hellip;</li>' . "\n";

		$class = $paged == $max ? ' class="current"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link($max)), $max);
	}

	/*	Next Post Link */
	if(get_next_posts_link())
		printf('<li id="next-page-link">%s</li>' . "\n", get_next_posts_link());
	echo '<div class="clear"></div>';
	echo '</ul></div>' . "\n";

}
add_shortcode( 'ct-listings', 'ct_listings_shortcode' );

/*-----------------------------------------------------------------------------------*/
/* Add Listings Shortcode to Visual Composer if the plugin is enabled */
/*-----------------------------------------------------------------------------------*/

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if(is_plugin_active('js_composer/js_composer.php')) {

	if(!function_exists('ct_listings_integrateWithVC')) {
		add_action( 'vc_before_init', 'ct_listings_integrateWithVC' );
		function ct_listings_integrateWithVC() {
		   vc_map( array(
		      "name" => __( "CT Listings", "contempo" ),
		      "base" => "ct-listings",
		      "class" => "",
		      "icon" => get_template_directory_uri() . "/images/ct-icon.png",
		      "category" => __( "CT Modules", "contempo"),
		      'description' => __( 'Display listings in standard grid layout.', 'contempo'),
		      "params" => array(
		      	array(
		            "type" => "dropdown",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Layout", "contempo" ),
		            "param_name" => "layout",
		            "value" => array(
		            	"grid" => "Grid",
		            	"list" => "List",
	            	),
		            "description" => __( "Choose the style of grid or list.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Number", "contempo" ),
				    "param_name" => "number",
				    "value" => __( "", "contempo" ),
				    "description" => __( "Enter the number to show per page, if you'd like to show all enter -1.", "contempo" )
				 ),
				 array(
				    "type" => "dropdown",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Order", "contempo" ),
				    "param_name" => "order",
				    "value" => array(
				    	"ASC" => "ASC",
				    	"DESC" => "DESC",
					),
				    "description" => __( "Order ascending or descending.", "contempo" )
				 ),
				 array(
				    "type" => "dropdown",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Order By", "contempo" ),
				    "param_name" => "orderby",
				    "value" => array(
				    	"Date" => "date",
				    	"Meta (Price)" => "meta_value",
				    	"Random" => "rand",
					),
				    "description" => __( "Order by Date, Price or Random.", "contempo" )
				 ),
				 array(
				    "type" => "dropdown",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Meta Key", "contempo" ),
				    "param_name" => "meta_key",
				    "value" => array(
				    	"Date" => "",
				    	"Price" => "_ct_price",
					),
				    "description" => __( "If selected price above select Price here.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Type", "contempo" ),
				    "param_name" => "type",
				    "value" => "",
				    "description" => __( "Enter the type, e.g. single-family-home, commercial.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Beds", "contempo" ),
				    "param_name" => "beds",
				    "value" => "",
				    "description" => __( "Enter the beds, e.g. 2, 3, 4.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Baths", "contempo" ),
				    "param_name" => "baths",
				    "value" => "",
				    "description" => __( "Enter the baths, e.g. 2, 3, 4.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Status", "contempo" ),
				    "param_name" => "status",
				    "value" => "",
				    "description" => __( "Enter the status, e.g. for-sale, for-rent, open-house.", "contempo" )
				 ),
				 array(
				    "type" => "dropdown",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Exclude Sold?", "contempo" ),
				    "param_name" => "sold",
				    "value" => array(
				    	"No" => "",
				    	"Yes" => "sold",
					),
				    "description" => __( "Choose if you'd like to exclude any listings with the Sold status.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "City", "contempo" ),
				    "param_name" => "city",
				    "value" => "",
				    "description" => __( "Enter the city, e.g. san-diego, los-angeles, new-york.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "State", "contempo" ),
				    "param_name" => "state",
				    "value" => "",
				    "description" => __( "Enter the state, e.g. ca, tx, ny.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Zip or Postcode", "contempo" ),
				    "param_name" => "zipcode",
				    "value" => "",
				    "description" => __( "Enter the zip or postcode, e.g. 92101, 92065, 94027.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "County", "contempo" ),
				    "param_name" => "county",
				    "value" => "",
				    "description" => __( "Enter the county, e.g. alpine-county, imperial-county, napa-county.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Country", "contempo" ),
				    "param_name" => "country",
				    "value" => "",
				    "description" => __( "Enter the country, e.g. usa, england, greece.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Community", "contempo" ),
				    "param_name" => "community",
				    "value" => "",
				    "description" => __( "Enter the community, e.g. the-grand-estates, broadstone-apartments.", "contempo" )
				 ),
				 array(
				    "type" => "textfield",
				    "holder" => "div",
				    "class" => "",
				    "heading" => __( "Additional Features", "contempo" ),
				    "param_name" => "additional_features",
				    "value" => "",
				    "description" => __( "Enter the additional features, e.g. pool, gated, beach-frontage.", "contempo" )
				 )
		      )
		   ) );
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Listings Shortcode */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listings_grid_shortcode')) {
	function ct_listings_grid_shortcode( $atts ) {

		// Attributes
		extract( shortcode_atts(
			array(
				'orderby' => '',
				'order' => '',
				'meta_key' => '',
				'meta_type' => '',
				'layout' => '2',
				'type' => '',
				'beds' => '',
				'baths' => '',
				'status' => '',
				'city' => '',
				'state' => '',
				'zipcode' => '',
				'country' => '',
				'community' => '',
				'additional_features' => ''
			), $atts )
		);

		// Output
		echo '<ul class="col span_12 row first">';

			global $post;
			global $ct_options;

	    	$args = array(
	            'ct_status' => $status,
	            'property_type' => $type,
	            'beds' => $beds,
	            'baths' => $baths,
	            'city' => $city,
	            'state' => $state,
	            'zipcode' => $zipcode,
	            'country' => $country,
	            'community' => $community,
	            'additional_features' => $additional_features,
	            'post_type' => 'listings',
	            'orderby' => $orderby,
				'order' => $order,
				'meta_key' => $meta_key,
				'meta_type' => 'numeric',
	            'posts_per_page' => $layout
	        );
	        $wp_query = new wp_query( $args ); 
	        
	        $count = 0; if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();

	        if(taxonomy_exists('city')){
		        $city = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
		    }
		    if(taxonomy_exists('state')){
		        $state = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
		    }
		    if(taxonomy_exists('zipcode')){
		        $zipcode = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );
		    }
		    if(taxonomy_exists('country')){
		        $country = strip_tags( get_the_term_list( $wp_query->post->ID, 'country', '', ', ', '' ) );
		    }

	        $beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
		    $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

		    $ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';
			$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
			$ct_listing_stats_on_off = isset( $ct_options['ct_listing_stats_on_off'] ) ? esc_attr( $ct_options['ct_listing_stats_on_off'] ) : '';
		    
		    $ct_walkscore = isset( $ct_options['ct_enable_walkscore'] ) ? esc_html( $ct_options['ct_enable_walkscore'] ) : '';
		    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
		    $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

		    if($ct_walkscore == 'yes') {
			    /* Walk Score */
			   	$latlong = get_post_meta($post->ID, "_ct_latlng", true);
			   	if($latlong != '') {
					list($lat, $long) = explode(',',$latlong,2);
					$address = get_the_title() . ct_taxonomy_return('city') . ct_taxonomy_return('state') . ct_taxonomy_return('zipcode');
					$json = ct_get_walkscore($lat,$long,$address);

					$ct_ws = json_decode($json);
				}
			}

	        ?>
	        
	        <?php if($layout == '2') { ?>
	        	<li class="listing col span_6 minimal <?php if($count == 0) { echo 'first'; } ?>">
	    	<?php } elseif($layout == '3') { ?>
	        	<li class="listing col <?php if($count == 0) { echo 'span_8 first'; } else { echo 'span_4'; } ?> minimal">
	        <?php } elseif($layout == '4') { ?>
	        	<li class="listing col span_6 minimal <?php if($count == 0 || $count == 2) { echo 'first'; } ?>">
		    <?php } elseif ($layout == '6') { ?>
	        	<li class="listing col <?php if($count == 0 || $count == 1) { echo 'span_6'; } else { echo 'span_3'; } ?> minimal <?php if($count == 0 || $count == 2) { echo 'first'; } ?>">
	         <?php } elseif ($layout == '7') { ?>
	        	<li class="listing col <?php if($count == 0 || $count == 1 || $count == 2) { echo 'span_4'; } else { echo 'span_3'; } ?> minimal <?php if($count == 0 || $count == 3) { echo 'first'; } ?>">
	        <?php } elseif($layout == '8') { ?>
	        	<li class="listing col span_3 minimal <?php if($count == 0 || $count == 4) { echo 'first'; } ?>">
	        <?php } ?>

	            <figure>
	            	<?php
	           			if(has_term( 'featured', 'ct_status' ) ) {
							echo '<h6 class="snipe featured">';
								echo '<span>';
									echo __('Featured', '');
								echo '</span>';
							echo '</h6>';
						}
					?>
	                <?php
		                $status_tags = strip_tags( get_modified_term_list_name( $wp_query->post->ID, 'ct_status', '', ' ', '', array('featured') ) );
						if($status_tags != '') {
							echo '<h6 class="snipe status ';
									$status_terms = strip_tags( get_modified_term_list_slug( $wp_query->post->ID, 'ct_status', '', ' ', '', array('featured') ) );
									if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
									     echo esc_html($status_terms) . ' ';
									 }
								echo '">';
								echo '<span>';
									echo esc_html($status_tags);
								echo '</span>';
							echo '</h6>';
						}
	                ?>
	                <?php if( function_exists('ct_property_type_icon') ) {
	                	ct_property_type_icon();
	            	} ?>
	                <?php
							echo '<ul class="listing-actions">';

								// Count Total images
						        $attachments = get_children(
						            array(
						                'post_type' => 'attachment',
						                'post_mime_type' => 'image',
						                'post_parent' => get_the_ID()
						            )
						        );

						        $img_count = count($attachments);

						        $feat_img = 1;
						        $total_imgs = $img_count + $feat_img;

								echo '<li>';
									echo '<span class="listing-views" data-tooltip="' . $img_count . __(' Photos','contempo') . '">';
										echo '<i class="fa fa-image"></i>';
									echo '</span>';
								echo '</li>';
								
								if (function_exists('wpfp_link')) {
									echo '<li>';
										echo '<span class="save-this" data-tooltip="' . __('Favorite','contempo') . '">';
											wpfp_link();
										echo '</span>';
									echo '</li>';
								}

								if(class_exists('Redq_Alike')) {
									echo '<li>';
										echo '<span class="compare-this" data-tooltip="' . __('Compare','contempo') . '">';
											echo do_shortcode('[alike_link vlaue="compare" show_icon="true" icon_class="fa fa-plus-square-o"]');
										echo '</span>';
									echo '</li>';
								}

								if(function_exists('ct_get_listing_views') && $ct_listing_stats_on_off != 'no') {
									echo '<li>';
										echo '<span class="listing-views" data-tooltip="' . ct_get_listing_views(get_the_ID()) . __(' Views','contempo') . '">';
											echo '<i class="fa fa-bar-chart"></i>';
										echo '</span>';
									echo '</li>';
								}

							echo '</ul>';
						?>
	                <?php if( function_exists('ct_first_image_linked') ) {
	                	ct_first_image_linked();
	                } ?>
	            </figure>
	            <div class="grid-listing-info">
		            <header>
		                <h5 class="marB0"><a href="<?php the_permalink(); ?>"><?php if( function_exists('ct_listing_title') ) { ct_listing_title(); } ?></a></h5>
		                <p class="location muted marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
	                </header>
	                <p class="price marB0"><?php if( function_exists('ct_listing_price') ) { ct_listing_price(); } ?></p>
		            <div class="propinfo">
		            	<p><?php if( function_exists('ct_excerpt') ) { echo ct_excerpt(25); } ?></p>
		                <ul class="marB0">
							<?php

						    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) { 
						        // Dont Display Bed/Bath
						    } else {
						    	if(!empty($beds)) {
							    	echo '<li class="row beds">';
							    		echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Bed', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-bed"></i>';
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo $beds;
							            echo '</span>';
							        echo '</li>';
							    }	
							    if(!empty($baths)) {
							        echo '<li class="row baths">';
							            echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Baths', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-bath"></i>';
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo $baths;
							            echo '</span>';
							        echo '</li>';
							    }
						    }

						    if($ct_walkscore == 'yes') {
							    if(!empty($ct_ws->walkscore)) {
								    echo '<li class="row walkscore">';
										echo '<span class="muted left">';
											_e('Walk Score&reg;', 'contempo');
										echo '</span>';
										echo '<span class="right">';
											echo '<a class="tooltips" href=" ' . $ct_ws->ws_link , '" target="_blank">';
										        echo $ct_ws->walkscore;
										        echo '<span>' . $ct_ws->description. '</span>';
									        echo '</a>';
								        echo '</span>';
								    echo '</li>';
								}
							}

							include_once ABSPATH . 'wp-admin/includes/plugin.php';
							if($ct_listing_reviews == 'yes' || is_plugin_active('comments-ratings/comments-ratings.php')) {
								global $pixreviews_plugin;
								$ct_rating_avg = $pixreviews_plugin->get_average_rating();
								if($ct_rating_avg != '') {
									echo '<li class="row rating">';
							            echo '<span class="muted left">';
							                if($ct_use_propinfo_icons != 'icons') {
								    			_e('Rating', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-star"></i>';
								    		}
							            echo '</span>';
							            echo '<span class="right">';
							                 echo $pixreviews_plugin->get_average_rating();
							            echo '</span>';
							        echo '</li>';
							    }
							}

						    include_once ABSPATH . 'wp-admin/includes/plugin.php';
							if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {
							    if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
							        echo '<li class="row guests">';
							            echo '<span class="muted left">';
							                if($ct_use_propinfo_icons != 'icons') {
								    			_e('Guests', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-group"></i>';
								    		}
							            echo '</span>';
							            echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_rental_guests", true);
							            echo '</span>';
							        echo '</li>';
							    }

							    if(get_post_meta($post->ID, "_ct_rental_min_stay", true)) {
							        echo '<li class="row min-stay">';
							            echo '<span class="muted left">';
							                if($ct_use_propinfo_icons != 'icons') {
								    			_e('Min Stay', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-calendar"></i>';
								    		}
							            echo '</span>';
							            echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_rental_min_stay", true);
							            echo '</span>';
							        echo '</li>';
							    }
							}
						    
						    if(get_post_meta($post->ID, "_ct_sqft", true)) {
						    	if($ct_use_propinfo_icons != 'icons') {
							        echo '<li class="row sqft">';
							            echo '<span class="muted left">';
							    			ct_sqftsqm();
							    		echo '</span>';
							    		echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_sqft", true);
							            echo '</span>';
							        echo '</li>';
							    } else {
							    	echo '<li class="row sqft">';
							            echo '<span class="muted left">';
											ct_listing_size_icon();
							    		echo '</span>';
							    		echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_sqft", true);
							                 echo ' ' . ct_sqftsqm();
							            echo '</span>';
							        echo '</li>';
							    }
						    }
						    
						    if(get_post_meta($post->ID, "_ct_lotsize", true)) {
						        if(get_post_meta($post->ID, "_ct_sqft", true)) {
						            echo '<li class="row lotsize">';
						        }
						            echo '<span class="muted left">';
						    			if($ct_use_propinfo_icons != 'icons') {
							    			_e('Lot Size', 'contempo');
							    		} else {
							    			echo '<i class="fa fa-arrows-alt"></i>';
							    		}
						    		echo '</span>';
						    		echo '<span class="right">';
						                 echo get_post_meta($post->ID, "_ct_lotsize", true) . ' ';
						                 ct_acres();
						            echo '</span>';
						            
						        if((get_post_meta($post->ID, "_ct_sqft", true))) {
						            echo '</li>';
						        }
						    } ?>
	                    </ul>
	                </div>
	            </div>
		
	        </li>
	        
	        <?php
			
			$count++;
			
			if ($layout == '6' && $count == '2') {
				echo '<div class="clear"></div>';
			}

			if($layout == '2' && $count == '2') {
	        	echo '<div class="clear"></div>';
	        } elseif($layout == '3' && $count == '3') {
	        	echo '<div class="clear"></div>';
	        } elseif($layout == '4' && $count == '4') {
	        	echo '<div class="clear"></div>';
		    } elseif ($layout == '6' && $count == '6') {
	        	echo '<div class="clear"></div>';
	        } elseif ($layout == '7' && $count == '7') {
	        	echo '<div class="clear"></div>';
	        } elseif($layout == '8' && $count == '4') {
	        	echo '<div class="clear"></div>';
	        }
			
			endwhile; endif;
			wp_reset_postdata();

		echo '</ul>';
		    echo '<div class="clear"></div>';
		
	}
}
add_shortcode( 'ct-listings-grid', 'ct_listings_grid_shortcode' );

/*-----------------------------------------------------------------------------------*/
/* Add Listings Shortcode to Visual Composer if the plugin is enabled */
/*-----------------------------------------------------------------------------------*/

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if(is_plugin_active('js_composer/js_composer.php')) {

	if(!function_exists('ct_listings_grid_integrateWithVC')) {
		add_action( 'vc_before_init', 'ct_listings_grid_integrateWithVC' );
		function ct_listings_grid_integrateWithVC() {
		   vc_map( array(
		      "name" => __( "CT Listings Minimal Grid", "contempo" ),
		      "base" => "ct-listings-grid",
		      "class" => "",
		      "icon" => get_template_directory_uri() . "/images/ct-icon.png",
		      "category" => __( "CT Modules", "contempo"),
		      'description' => __( 'Display listings items in a beautiful minimal style grid layout.', 'contempo'),
		      "params" => array(
		         array(
		            "type" => "dropdown",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Layout", "contempo" ),
		            "param_name" => "layout",
		            "value" => array(
		            	"2" => "2",
		            	"3" => "3",
		            	"4" => "4",
		            	"6" => "6",
		            	"7" => "7",
		            	"8" => "8",
	            	),
		            "description" => __( "Choose the grid layout you'd like to use.", "contempo" )
		         ),
		         array(
		            "type" => "dropdown",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Order", "contempo" ),
		            "param_name" => "order",
		            "value" => array(
		            	"ASC" => "ASC",
		            	"DESC" => "DESC",
	            	),
		            "description" => __( "Order ascending or descending.", "contempo" )
		         ),
		         array(
		            "type" => "dropdown",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Order By", "contempo" ),
		            "param_name" => "orderby",
		            "value" => array(
		            	"Date" => "date",
		            	"Meta (Price)" => "meta_value",
		            	"Random" => "rand",
	            	),
		            "description" => __( "Order by Date, Price or Random.", "contempo" )
		         ),
		         array(
		            "type" => "dropdown",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Meta Key", "contempo" ),
		            "param_name" => "meta_key",
		            "value" => array(
		            	"Date" => "",
		            	"Price" => "_ct_price",
	            	),
		            "description" => __( "If selected price above select Price here.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Type", "contempo" ),
		            "param_name" => "type",
		            "value" => "",
		            "description" => __( "Enter the type, e.g. single-family-home, commercial.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Beds", "contempo" ),
		            "param_name" => "beds",
		            "value" => "",
		            "description" => __( "Enter the beds, e.g. 2, 3, 4.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Baths", "contempo" ),
		            "param_name" => "baths",
		            "value" => "",
		            "description" => __( "Enter the baths, e.g. 2, 3, 4.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Status", "contempo" ),
		            "param_name" => "status",
		            "value" => "",
		            "description" => __( "Enter the status, e.g. for-sale, for-rent, open-house.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "City", "contempo" ),
		            "param_name" => "city",
		            "value" => "",
		            "description" => __( "Enter the city, e.g. san-diego, los-angeles, new-york.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "State", "contempo" ),
		            "param_name" => "state",
		            "value" => "",
		            "description" => __( "Enter the state, e.g. ca, tx, ny.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Zip or Postcode", "contempo" ),
		            "param_name" => "zipcode",
		            "value" => "",
		            "description" => __( "Enter the zip or postcode, e.g. 92101, 92065, 94027.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Country", "contempo" ),
		            "param_name" => "country",
		            "value" => "",
		            "description" => __( "Enter the country, e.g. usa, england, greece.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Community", "contempo" ),
		            "param_name" => "community",
		            "value" => "",
		            "description" => __( "Enter the community, e.g. the-grand-estates, broadstone-apartments.", "contempo" )
		         ),
		         array(
		            "type" => "textfield",
		            "holder" => "div",
		            "class" => "",
		            "heading" => __( "Additional Features", "contempo" ),
		            "param_name" => "additional_features",
		            "value" => "",
		            "description" => __( "Enter the additional features, e.g. pool, gated, beach-frontage.", "contempo" )
		         )
		      )
		   ) );
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Listings Search Shortcode */
/*-----------------------------------------------------------------------------------

function ct_listings_search_shortcode( $atts ) {

	global $ct_options;

	$ct_home_adv_search_fields = isset( $ct_options['ct_home_adv_search_fields']['enabled'] ) ? $ct_options['ct_home_adv_search_fields']['enabled'] : '';
	$ct_enable_adv_search_page = isset( $ct_options['ct_enable_adv_search_page'] ) ? $ct_options['ct_enable_adv_search_page'] : '';
	$ct_adv_search_page = isset( $ct_options['ct_adv_search_page'] ) ? $ct_options['ct_adv_search_page'] : '';

	// Attributes
	extract( shortcode_atts(
		array(
			'search-layout' => 'horizontal',
		), $atts )
	);

		$output = '<form id="advanced_search" name="search-listings" action="' . home_url() . '">';

		    $output .= '<div class="form-loader"><i class="fa fa-circle-o-notch fa-spin"></i></div>';
		    
		    if ($ct_home_adv_search_fields) :
		    
		    foreach ($ct_home_adv_search_fields as $field=>$value) {
		    
		        switch($field) {
					
				// Type            
		        case 'type' : 
		            $output .= '<div class="left">';
		                $output .= ct_search_form_select('property_type');
		            $output .= '</div>';
		        
				break;
				
				// City
				case 'city' : ?>
				<div class="left">
					<label for="ct_city"><?php _e('City', 'contempo'); ?></label>
					<?php ct_search_form_select('city'); ?>
				</div>
		        <?php
				break;
				
		        // State            
		        case 'state' : ?>
		            <div class="left">
		                <?php
		                global $ct_options;
		                $ct_state_or_area = isset( $ct_options['ct_state_or_area'] ) ? $ct_options['ct_state_or_area'] : '';

		                if($ct_state_or_area == 'area') { ?>
		                    <label for="ct_state"><?php _e('Area', 'contempo'); ?></label>
		                <?php } elseif($ct_state_or_area == 'suburb') { ?>
		                    <label for="ct_state"><?php _e('Suburb', 'contempo'); ?></label>
		                <?php } else { ?>
		                    <label for="ct_state"><?php _e('State', 'contempo'); ?></label>
		                <?php } ?>
						<?php ct_search_form_select('state'); ?>
		            </div>
		        <?php
				break;
				
				// Zipcode            
		        case 'zipcode' : ?>
		            <div class="left">
		                <?php
		                global $ct_options;
		                $ct_zip_or_post = isset( $ct_options['ct_zip_or_post'] ) ? $ct_options['ct_zip_or_post'] : '';

		                if($ct_zip_or_post == 'postcode') { ?>
		                    <label for="ct_zipcode"><?php _e('Postcode', 'contempo'); ?></label>
		                <?php } else { ?>
		                    <label for="ct_zipcode"><?php _e('Zipcode', 'contempo'); ?></label>
		                <?php } ?>
						<?php ct_search_form_select('zipcode'); ?>
		            </div>
		        <?php
				break;

		        // Country            
		        case 'country' : ?>
		            <div class="left">
		                <label for="ct_country"><?php _e('Country', 'contempo'); ?></label>
		                <?php ct_search_form_select('country'); ?>
		            </div>
		        <?php
		        break;

		        // Community            
		        case 'type' : ?>
		            <div class="left">
		                <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
		                <?php ct_search_form_select('community'); ?>
		            </div>
		        <?php
		        break;
				
				// Beds            
		        case 'beds' : ?>
		            <div class="left">
		                <label for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
						<?php ct_search_form_select('beds'); ?>
		            </div>
		        <?php
				break;
				
				// Baths            
		        case 'baths' : ?>
		            <div class="left">
		                <label for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
						<?php ct_search_form_select('baths'); ?>
		            </div>
		        <?php
				break;
				
				// Status            
		        case 'status' : ?>
		            <div class="left">
		                <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
						<?php ct_search_form_select('ct_status'); ?>
		            </div>
		        <?php
				break;
				
				// Additional Features            
		        case 'additional_features' : ?>
		            <div class="left">
		                <label for="ct_additional_features"><?php _e('Additional Features', 'contempo'); ?></label>
						<?php ct_search_form_select('additional_features'); ?>
		            </div>
		        <?php
				break;

		        // Community          
		        case 'community' : ?>
		            <div class="left">
		                <?php
		                global $ct_options;
		                $ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

		                if($ct_community_neighborhood_or_district == 'neighborhood') { ?>
		                    <label for="ct_community"><?php _e('Neighborhood', 'contempo'); ?></label>
		                <?php } elseif($ct_community_neighborhood_or_district == 'district') { ?>
		                    <label for="ct_community"><?php _e('District', 'contempo'); ?></label>
		                <?php } else { ?>
		                    <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
		                <?php } ?>
		                <?php ct_search_form_select('community'); ?>
		            </div>
		        <?php
		        break;
				
				// Price From            
		        case 'price_from' :
		            $output .= '<div class="left">';
		                $output .= '<label for="ct_price_from">' . __('Price From', 'contempo') . '(' . ct_currency() . ')</label>';
		                $output .= '<input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="' . __('Price From', 'contempo') . '(' . ct_currency() . ')" />';
		            $output .= '</div>';
				break;
				
				// Price To            
		        case 'price_to' : ?>
		            <div class="left">
		                <label for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
		                <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" />
		            </div>
		        <?php
				break;

		        // Sq Ft From            
		        case 'sqft_from' : ?>
		            <div class="left">
		                <label for="ct_sqft_from"><?php ct_sqftsqm(); ?> <?php _e('From', 'contempo'); ?></label>
		                <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
		            </div>
		        <?php
		        break;
		        
		        // Sq Ft To            
		        case 'sqft_to' : ?>
		            <div class="left">
		                <label for="ct_sqft_to"><?php ct_sqftsqm(); ?> <?php _e('To', 'contempo'); ?></label>
		                <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
		            </div>
		        <?php
		        break;

		        // Lot Size From            
		        case 'lotsize_from' : ?>
		            <div class="left">
		                <label for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
		                <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
		            </div>
		        <?php
		        break;
		        
		        // Lot Size To            
		        case 'lotsize_to' : ?>
		            <div class="left">
		                <label for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
		                <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
		            </div>
		        <?php
		        break;
				
				// MLS            
		        case 'mls' : ?>
		            <div class="left">
		                <label for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
		                <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" />
		            </div>
		        <?php
				break;

		        // Number of Guests            
		        case 'numguests' : ?>
		            <div class="left">
		                <label for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
		                <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" />
		            </div>
		        <?php
		        break;

		        // Keyword           
		        case 'keyword' : ?>
		            <div class="left">
		                <label for="ct_keyword"><?php _e('Keyword', 'contempo'); ?></label>
		                <input type="text" id="ct_keyword" class="number" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Keyword', 'contempo'); ?>" />
		            </div>
		        <?php
		        break;

		        }
		    
		    } endif;
		    
		    $output .= '<input type="hidden" name="search-listings" value="true" />';

		    $output .= '<input id="submit" class="btn left" type="submit" value="' . __('Search', 'contempo') . '" />';

		    if($ct_enable_adv_search_page == 'yes' && $ct_adv_search_page != '') {
		        $output .= '<div class="left">';
		            $output .= '<a class="btn more-search-options" href="' . home_url() . '/?page_id=' . $ct_adv_search_page . '">' . __('More Search Options', 'contempo') . '</a>';
		        $output .= '</div>';
		    }
		    
		    $output .= '<div class="left makeloading"><i class="fa fa-circle-o-notch fa-spin"></i></div>';
		        $output .= '<div class="clear"></div>';
		$output .= '</form>';

		return $output;
	
}
add_shortcode( 'ct-listings-search', 'ct_listings_search_shortcode' );

/*-----------------------------------------------------------------------------------
/* Add Listings Search Shortcode to Visual Composer if the plugin is enabled */
/*-----------------------------------------------------------------------------------

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if(is_plugin_active('js_composer/js_composer.php')) {

	add_action( 'vc_before_init', 'ct_listings_search_integrateWithVC' );
	function ct_listings_search_integrateWithVC() {
	   vc_map( array(
	      "name" => __( "CT Listings Search", "contempo" ),
	      "base" => "ct-listings-search",
	      "class" => "",
	      "icon" => get_template_directory_uri() . "/images/ct-icon.png",
	      "category" => __( "CT Modules", "contempo"),
	      'description' => __( 'Display listings search, uses the global layout set via Real Estate 7 Options > Advanced Search.', 'contempo'),
	      "params" => array(
	         array(
	            "type" => "dropdown",
	            "holder" => "div",
	            "class" => "",
	            "heading" => __( "Layout Style", "contempo" ),
	            "param_name" => "search-layout",
	            "value" => array(
	            	"horizontal" => "Horizontal",
	            	"vertical" => "Vertical",
            	),
	            "description" => __( "Choose the layout style you'd like to use.", "contempo" )
	         ),
	      )
	   ) );
	}
}
*/

if(version_compare(PHP_VERSION, '5.6.0') >= 0) {

	/*-----------------------------------------------------------------------------------*/
	/* Info Grid 3 Shortcode */
	/*-----------------------------------------------------------------------------------*/

	if(!function_exists('ct_info_grid_three_shortcode')) {
		function ct_info_grid_three_shortcode( $atts ) {

			// Attributes
			extract( shortcode_atts(
				array(
					'ct_item_title_one' => '',
					'ct_item_link_one' => '',
					'ct_item_description_one' => '',
					'ct_item_image_one' => '',
					'ct_item_title_two' => '',
					'ct_item_link_two' => '',
					'ct_item_description_two' => '',
					'ct_item_image_two' => '',
					'ct_item_title_three' => '',
					'ct_item_link_three' => '',
					'ct_item_description_three' => '',
					'ct_item_image_three' => '',
				), $atts )
			);

			// Output
			$output = '<ul class="item-grid grid-three-item">';
				$output .= '<li class="grid-item col span_8 first" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_one, 'full')[0] . '); background-size: cover;">';
					$output .= '<a href="' . $ct_item_link_one . '">';
						//$output .= '<figure>';
						//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_one, 'full')[0] . '" / >';
						//$output .= '</figure>';
						$output .= '<div class="grid-item-info">';
							$output .= '<h4>' . $ct_item_title_one . '</h4>';
							$output .= '<p>' . stripslashes($ct_item_description_one) . '</p>';
						$output .= '</div>';
					$output .= '</a>';
				$output .= '</li>';
				$output .= '<li class="grid-item col span_4" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_two, 'full')[0] . '); background-size: cover;">';
					$output .= '<a href="' . $ct_item_link_two . '">';
						//$output .= '<figure>';
						//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_two, 'full')[0] . '" / >';
						//$output .= '</figure>';
						$output .= '<div class="grid-item-info">';
							$output .= '<h4>' . $ct_item_title_two . '</h4>';
							$output .= '<p>' . stripslashes($ct_item_description_two) . '</p>';
						$output .= '</div>';
					$output .= '</a>';
				$output .= '</li>';
				$output .= '<li class="grid-item col span_4" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_three, 'full')[0] . '); background-size: cover;">';
					$output .= '<a href="' . $ct_item_link_three . '">';
						//$output .= '<figure>';
						//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_three, 'full')[0] . '" / >';
						//$output .= '</figure>';
						$output .= '<div class="grid-item-info">';
							$output .= '<h4>' . $ct_item_title_three . '</h4>';
							$output .= '<p>' . stripslashes($ct_item_description_three) . '</p>';
						$output .= '</div>';
					$output .= '</a>';
				$output .= '</li>';
					$output .= '<div class="clear"></div>';
			$output .= '</ul>';	

			return $output;
			
		}
	}
	add_shortcode( 'ct-info-grid-three', 'ct_info_grid_three_shortcode' );

	/*-----------------------------------------------------------------------------------*/
	/* Add Info Grid 3 Shortcode to Visual Composer if the plugin is enabled */
	/*-----------------------------------------------------------------------------------*/

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if(is_plugin_active('js_composer/js_composer.php')) {

		if(!function_exists('ct_info_grid_three_integrateWithVC')) {
			add_action( 'vc_before_init', 'ct_info_grid_three_integrateWithVC' );
			function ct_info_grid_three_integrateWithVC() {
				$ct_prefix = 'ct_';
				vc_map( array(
				  'name' => __( 'CT 3 Item Grid', 'contempo' ),
				  'description' => __( 'Display any three content items in a beautiful grid layout.', 'contempo'),
				  'base' => 'ct-info-grid-three',
				  'class' => '',
				  'icon' => get_template_directory_uri() . '/images/ct-icon.png',
				  'category' => __( 'CT Modules', 'contempo'),
				  'params' => array(
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_one',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_1'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_one',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_1'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_one',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_1'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_one',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_1'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_two',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_2'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_two',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_2'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_two',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_2'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_two',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_2'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_three',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_3'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_three',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_3'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_three',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_3'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_three',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_3'
				    ),
				  )
				) );
			}
		}
	}

	/*-----------------------------------------------------------------------------------*/
	/* Info Grid 6 Shortcode */
	/*-----------------------------------------------------------------------------------*/

	if(!function_exists('ct_info_grid_six_shortcode')) {
		function ct_info_grid_six_shortcode( $atts ) {

			// Attributes
			extract( shortcode_atts(
				array(
					'ct_item_title_one' => '',
					'ct_item_link_one' => '',
					'ct_item_description_one' => '',
					'ct_item_image_one' => '',
					'ct_item_title_two' => '',
					'ct_item_link_two' => '',
					'ct_item_description_two' => '',
					'ct_item_image_two' => '',
					'ct_item_title_three' => '',
					'ct_item_link_three' => '',
					'ct_item_description_three' => '',
					'ct_item_image_three' => '',
					'ct_item_title_four' => '',
					'ct_item_link_four' => '',
					'ct_item_description_four' => '',
					'ct_item_image_four' => '',
					'ct_item_title_five' => '',
					'ct_item_link_five' => '',
					'ct_item_description_five' => '',
					'ct_item_image_five' => '',
					'ct_item_title_six' => '',
					'ct_item_link_six' => '',
					'ct_item_description_six' => '',
					'ct_item_image_six' => '',
				), $atts )
			);

			// Output
			$output = '<ul class="item-grid grid-six-item">';
				$output .= '<li class="grid-item col span_8 first" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_one, 'full')[0] . '); background-size: cover;">';
					$output .= '<a href="' . $ct_item_link_one . '">';
						//$output .= '<figure>';
						//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_one, 'full')[0] . '" / >';
						//$output .= '</figure>';
						$output .= '<div class="grid-item-info">';
							$output .= '<h4>' . $ct_item_title_one . '</h4>';
							$output .= '<p>' . stripslashes($ct_item_description_one) . '</p>';
						$output .= '</div>';
					$output .= '</a>';
				$output .= '</li>';
				$output .= '<li class="grid-item col span_4" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_two, 'full')[0] . '); background-size: cover;">';
					$output .= '<a href="' . $ct_item_link_two . '">';
						//$output .= '<figure>';
						//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_two, 'full')[0] . '" / >';
						//$output .= '</figure>';
						$output .= '<div class="grid-item-info">';
							$output .= '<h4>' . $ct_item_title_two . '</h4>';
							$output .= '<p>' . stripslashes($ct_item_description_two) . '</p>';
						$output .= '</div>';
					$output .= '</a>';
				$output .= '</li>';
				$output .= '<li class="grid-item col span_4" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_three, 'full')[0] . '); background-size: cover;">';
					$output .= '<a href="' . $ct_item_link_three . '">';
						//$output .= '<figure>';
						//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_three, 'full')[0] . '" / >';
						//$output .= '</figure>';
						$output .= '<div class="grid-item-info">';
							$output .= '<h4>' . $ct_item_title_three . '</h4>';
							$output .= '<p>' . stripslashes($ct_item_description_three) . '</p>';
						$output .= '</div>';
					$output .= '</a>';
				$output .= '</li>';
					$output .= '<div class="clear"></div>';
				$output .= '<div class="col span_4 first" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_four, 'full')[0] . '); background-size: cover;">';
					$output .= '<li class="grid-item col span_12 first">';
						$output .= '<a href="' . $ct_item_link_four . '">';
							//$output .= '<figure>';
							//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_four, 'full')[0] . '" / >';
							//$output .= '</figure>';
							$output .= '<div class="grid-item-info">';
								$output .= '<h4>' . $ct_item_title_four . '</h4>';
								$output .= '<p>' . stripslashes($ct_item_description_four) . '</p>';
							$output .= '</div>';
						$output .= '</a>';
					$output .= '</li>';
					$output .= '<li class="grid-item col span_12 first" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_five, 'full')[0] . '); background-size: cover;">';
						$output .= '<a href="' . $ct_item_link_five . '">';
							//$output .= '<figure>';
							//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_five, 'full')[0] . '" / >';
							//$output .= '</figure>';
							$output .= '<div class="grid-item-info">';
								$output .= '<h4>' . $ct_item_title_five . '</h4>';
								$output .= '<p>' . stripslashes($ct_item_description_five) . '</p>';
							$output .= '</div>';
						$output .= '</a>';
					$output .= '</li>';
				$output .= '</div>';
				$output .= '<div class="col span_8">';
					$output .= '<li class="grid-item col span_12 first" style="background-image: url(' . wp_get_attachment_image_src($ct_item_image_six, 'full')[0] . '); background-size: cover;">';
						$output .= '<a href="' . $ct_item_link_six . '">';
							//$output .= '<figure>';
							//	$output .= '<img src="' . wp_get_attachment_image_src($ct_item_image_six, 'full')[0] . '" / >';
							//$output .= '</figure>';
							$output .= '<div class="grid-item-info">';
								$output .= '<h4>' . $ct_item_title_six . '</h4>';
								$output .= '<p>' . stripslashes($ct_item_description_six) . '</p>';
							$output .= '</div>';
						$output .= '</a>';
					$output .= '</li>';
				$output .= '</div>';
					$output .= '<div class="clear"></div>';
			$output .= '</ul>';	

			return $output;
			
		}
	}
	add_shortcode( 'ct-info-grid-six', 'ct_info_grid_six_shortcode' );

	/*-----------------------------------------------------------------------------------*/
	/* Add Info Grid 3 Shortcode to Visual Composer if the plugin is enabled */
	/*-----------------------------------------------------------------------------------*/

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if(is_plugin_active('js_composer/js_composer.php')) {

		if(!function_exists('ct_info_grid_six_integrateWithVC')) {
			add_action( 'vc_before_init', 'ct_info_grid_six_integrateWithVC' );
			function ct_info_grid_six_integrateWithVC() {
				$ct_prefix = 'ct_';
				vc_map( array(
				  'name' => __( 'CT 6 Item Grid', 'contempo' ),
				  'description' => __( 'Display any six content items in a beautiful grid layout.', 'contempo'),
				  'base' => 'ct-info-grid-six',
				  'class' => '',
				  'icon' => get_template_directory_uri() . '/images/ct-icon.png',
				  'category' => __( 'CT Modules', 'contempo'),
				  'params' => array(
				  	// Item 1
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_one',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_1'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_one',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_1'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_one',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_1'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_one',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_1'
				    ),
				    // Item 2
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_two',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_2'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_two',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_2'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_two',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_2'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_two',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_2'
				    ),
				    // Item 3
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_three',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_3'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_three',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_3'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_three',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_3'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_three',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_3'
				    ),
				    // Item 4
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_four',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_4'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_four',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_4'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_four',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_4'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_four',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_4'
				    ),
				    // Item 5
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_five',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_5'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_five',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_5'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_five',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_5'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_five',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_5'
				    ),
				    // Item 6
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Title', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_title_six',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the title here.', 'contempo' ),
				        'group' => 'item_6'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_link_six',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
				        'group' => 'item_6'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'item_description_six',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'item_6'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'item_image_six',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'item_6'
				    ),
				  )
				) );
			}
		}
	}
}

if(version_compare(PHP_VERSION, '5.6.0') >= 0) {

	/*-----------------------------------------------------------------------------------*/
	/* Open House Shortcode */
	/*-----------------------------------------------------------------------------------*/

	if(!function_exists('ct_openhouse_shortcode')) {
		function ct_openhouse_shortcode( $atts ) {

			// Attributes
			extract( shortcode_atts(
				array(
					'ct_open_house_layout' => '',
					'ct_open_house_link' => '',
					'ct_open_house_description' => '',
					'ct_open_house_date' => '',
					'ct_open_house_start_time' => '',
					'ct_open_house_end_time' => '',
					'ct_open_house_street_address' => '',
					'ct_open_house_city' => '',
					'ct_open_house_state' => '',
					'ct_open_house_zip' => '',
					'ct_open_house_country' => '',
					'ct_open_house_image' => '',
				), $atts )
			);

			$href = vc_build_link($ct_open_house_link);

			// Output
			if($ct_open_house_layout == 'Grid') {
				$output = '<div class="listing open-house-listing col span_12 first">';
			} else {
				$output = '<div class="listing open-house-listing listing-list col span_12 first">';
			}
				
				if(!empty($ct_open_house_image)) {
					if($ct_open_house_layout == 'Grid') {
						$output .= '<figure">';
					} else {
						$output .= '<figure class="col span_4 first">';
					}
						$output .= '<img src="' . wp_get_attachment_image_src($ct_open_house_image, 'full')[0] . '" alt="' . $ct_open_house_street_address . '" />';
					$output .= '</figure>';
				}

					if($ct_open_house_layout == 'Grid') {
						$output .= '<div class="grid-listing-info">';
					} else {
						$output .= '<div class="list-listing-info col span_8 first">';
					}
			            $output .= '<div class="list-listing-info-inner vc-open-house-inner">';
			               
			                $output .= '<header>';
			                	if(!empty($ct_open_house_street_address)) {
			                		$output .= '<h4 class="open-house-street-address marT0 marB0">';
			                			$output .= $ct_open_house_street_address;
			                		$output .= '</h4>';
			                	}
			                	if(!empty($ct_open_house_city) || !empty($ct_open_house_state) || !empty($ct_open_house_zip) || !empty($ct_open_house_country)) {
				                	$output .= '<p class="location muted marB0">';
					                	if(!empty($ct_open_house_city)) {
					                		$output .= '<span class="open-house-city">';
					                			$output .= $ct_open_house_city;
					                		$output .= '</span>';
					                	}
					                	if(!empty($ct_open_house_state)) {
					                		$output .= '<span class="open-house-state">';
					                			$output .= ', ' . $ct_open_house_state . ' ';
					                		$output .= '</span>';
					                	}
					                	if(!empty($ct_open_house_zip)) {
					                		$output .= '<span class="open-house-zip">';
					                			$output .= $ct_open_house_zip . ' ';
					                		$output .= '</span>';
					                	}
					                	if(!empty($ct_open_house_country)) {
					                		$output .= '<span class="open-house-country">';
					                			$output .= $ct_open_house_country;
					                		$output .= '</span>';
					                	}
					                $output .= '</p>';
					            }
			                $output .= '</header>';

			                if(!empty($ct_open_house_description) && $ct_open_house_layout == 'Grid') {
		                		$output .= '<p class="open-house-description marB0">';
                                       $output .= $ct_open_house_description;
		                		$output .= '</p>';
		                	}

			                if(!empty($ct_open_house_date) || !empty($ct_open_house_start_time) || !empty($ct_open_house_end_time)) {
			                	if($ct_open_house_layout == 'Grid') {
					                $output .= '<ul class="propinfo marT20 marR0 marL0 pad0">';
					            } else {
					            	$output .= '<ul class="propinfo propinfo-list marB0 marL0 padT0">';
					            }
				                	if(!empty($ct_open_house_date)) {
				                		if($ct_open_house_layout == 'Grid') {
					                		$output .= '<li class="open-house-date row">';
					                	} else {
					                		$output .= '<li class="open-house-date">';
					                	}
				                			$output .= '<span class="muted left">';
					                			if($ct_open_house_layout == 'Grid') {
			                                        $output .= __('Date:', 'contempo');
			                                    } else {
			                                    	$output .= __('Details:', 'contempo');
			                                    }
		                                    $output .= '</span>';
		                                    $output .= '<span class="right">';
		                                       $output .= $ct_open_house_date;
		                                    $output .='</span>';
				                		$output .= '</li>';
				                	}
				                	if(!empty($ct_open_house_start_time)) {
				                		if($ct_open_house_layout == 'Grid') {
					                		$output .= '<li class="open-house-start-time row">';
					                	} else {
					                		$output .= '<li class="open-house-start-time">';
					                	}
				                			$output .= '<span class="muted left">';
		                                        if($ct_open_house_layout == 'Grid') {
			                                        $output .= __('Start Time:', 'contempo');
			                                    } else {
			                                    	$output .= ' ';
			                                    }
		                                    $output .= '</span>';
		                                    $output .= '<span class="right">';
		                                       $output .= $ct_open_house_start_time;
		                                    $output .='</span>';
				                		$output .= '</li>';
				                	}
				                	if(!empty($ct_open_house_end_time)) {
				                		if($ct_open_house_layout == 'Grid') {
					                		$output .= '<li class="open-house-end-time row">';
					                	} else {
					                		$output .= '<li class="open-house-end-time">';
					                	}
				                			$output .= '<span class="muted left">';
		                                        if($ct_open_house_layout == 'Grid') {
			                                        $output .= __('End Time:', 'contempo');
			                                    } else {
			                                    	$output .= '-';
			                                    }
		                                    $output .= '</span>';
		                                    $output .= '<span class="right">';
		                                       $output .= $ct_open_house_end_time;
		                                    $output .='</span>';
				                		$output .= '</li>';
				                	}
				                $output .= '</ul>';
				            }

					            $output .= '<div class="clear"></div>';

				            if(!empty($ct_open_house_description) && $ct_open_house_layout == 'List') {
		                		$output .= '<p class="open-house-description marB0">';
                                       $output .= $ct_open_house_description;
		                		$output .= '</p>';
		                	}

		                	if(!empty($href['url'])) {
		                		$output .= '<p class="open-house-more-info marB30 marT30">';

			                	if($href['url'] !='' && $href['target'] != '') {
									$output .= '<a class="btn" href="' . $href['url'] . '" title="' . $href['title'] . '" target="' . $href['target'] . '">';
								} elseif($href['url'] != '') {
									$output .= '<a class="btn" href="' . $href['url'] . '" title="' . $href['title'] . '">';
								}

									$output .= $href['title'];

								if($href['url'] !='') {
									$output .= '</a>';
								}

								$output .= '</p">';
							}

			            $output .= '</div>';
			        $output .= '</div>';

			$output .= '</div>';

			return $output;
			
		}
	}
	add_shortcode( 'ct-open-house', 'ct_openhouse_shortcode' );

	/*-----------------------------------------------------------------------------------*/
	/* Add Open House Shortcode to Visual Composer if the plugin is enabled */
	/*-----------------------------------------------------------------------------------*/

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if(is_plugin_active('js_composer/js_composer.php')) {

		if(!function_exists('ct_openhouse_integrateWithVC')) {
			add_action( 'vc_before_init', 'ct_openhouse_integrateWithVC' );
			function ct_openhouse_integrateWithVC() {
				$ct_prefix = 'ct_';
				vc_map( array(
				  'name' => __( 'CT Open House', 'contempo' ),
				  'description' => __( 'Display an open house, date, start & end time, listing address.', 'contempo'),
				  'base' => 'ct-open-house',
				  'class' => '',
				  'icon' => get_template_directory_uri() . '/images/ct-icon.png',
				  'category' => __( 'CT Modules', 'contempo'),
				  'params' => array(
				  	array(
						'type' => 'dropdown',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Layout', 'contempo' ),
						'param_name' => $ct_prefix . 'open_house_layout',
						'value' => array(
							'--' => '--',
							'Grid' => 'Grid',
							'List' => 'List',
						),
						'description' => __( 'Select either a grid or list style layout.', 'contempo' ),
						'group' => 'General'
					),
				  	array(
				        'type' => 'vc_link',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Link', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_link',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter a URL here, or link to a specific listing.', 'contempo' ),
				        'group' => 'General'
				    ),
				    array(
				        'type' => 'textarea',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Description', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_description',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the description here.', 'contempo' ),
				        'group' => 'General'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Date', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_date',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the date here.', 'contempo' ),
				        'group' => 'Date/Time'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Start Time', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_start_time',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the start time here.', 'contempo' ),
				        'group' => 'Date/Time'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'End Time', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_end_time',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the end time here.', 'contempo' ),
				        'group' => 'Date/Time'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Street Address', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_street_address',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the street address here.', 'contempo' ),
				        'group' => 'Address'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'City', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_city',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the city here.', 'contempo' ),
				        'group' => 'Address'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'State', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_state',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the state here.', 'contempo' ),
				        'group' => 'Address'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Zip/Post Code', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_zip',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the zip/post code here.', 'contempo' ),
				        'group' => 'Address'
				    ),
				    array(
				        'type' => 'textfield',
				        'holder' => 'div',
				        'class' => '',
				        'heading' => __( 'Country', 'contempo' ),
				        'param_name' => $ct_prefix . 'open_house_country',
				        'value' => __( '', 'contempo' ),
				        'description' => __( 'Enter the country here.', 'contempo' ),
				        'group' => 'Address'
				    ),
		 		    array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __( 'Image', 'contempo' ),
						'param_name' => $ct_prefix . 'open_house_image',
						'value' => __( '', 'contempo' ),
						'description' => __( 'Upload an image here.', 'contempo' ),
						'group' => 'Image'
				    ),
				  )
				) );
			}
		}
	}

	/*-----------------------------------------------------------------------------------*/
	/* Agent Shortcode */
	/*-----------------------------------------------------------------------------------*/

	function ct_agent_shortcode( $atts ) {

		// Attributes
		extract( shortcode_atts(
			array(
				'ct_agent_name' => '',
				'ct_agent_title' => '',
				'ct_agent_link' => '',
				'ct_agent_description' => '',
				'ct_agent_image' => '',
			), $atts )
		);

		$href = vc_build_link($ct_agent_link);

		// Output
		$output = '<div class="vc-agent">';
			if($href['url'] !='' && $href['target'] != '') {
				$output .= '<a href="' . $href['url'] . '" title="' . $href['title'] . '" target="' . $href['target'] . '">';
			} elseif($href['url'] != '') {
				$output .= '<a href="' . $href['url'] . '" title="' . $href['title'] . '">';
			}
				if(!empty($ct_agent_image)) {
					$output .= '<figure>';
						$output .= '<img src="' . wp_get_attachment_image_src($ct_agent_image, 'full')[0] . '" alt="' . $ct_agent_name . '" />';
					$output .= '</figure>';
				}
			if($href['url'] !='') {
				$output .= '</a>';
			}
				$output .= '<div class="vc-agent-info">';

					if(!empty($ct_agent_name) || !empty($ct_agent_title)) {
						$output .= '<header>';
					}

						if($href['url'] !='' && $href['target'] != '') {
							$output .= '<a href="' . $href['url'] . '" title="' . $href['title'] . '" target="' . $href['target'] . '">';
						} elseif($href['url'] != '') {
							$output .= '<a href="' . $href['url'] . '" title="' . $href['title'] . '">';
						}
							if(!empty($ct_agent_name)) {
								$output .= '<h4>' . $ct_agent_name . '</h4>';
							}
						if($href['url'] !='') {
							$output .= '</a>';
						}
						if(!empty($ct_agent_title)) {
							$output .= '<h6 class="muted">' . $ct_agent_title . '</h6>';
						}

					if(!empty($ct_agent_name) || !empty($ct_agent_title)) {
						$output .= '</header>';
					}

					if(!empty($ct_agent_description)) {
						$output .= '<p>' . stripslashes($ct_agent_description) . '</p>';
					}
					if($href['url'] !='' && $href['target'] != '') {
						$output .= '<a class="btn" href="' . $href['url'] . '" title="' . $href['title'] . '" target="' . $href['target'] . '">';
					} elseif($href['url'] != '') {
						$output .= '<a class="btn" href="' . $href['url'] . '" title="' . $href['title'] . '">';
					}
						if($href['url'] !='') {
							$output .= __('View Profile', 'contempo');
						}

					if($href['url'] !='') {
						$output .= '</a>';
					}

				$output .= '</div>';
			$output .= '</a>';
		$output .= '</div>';

		return $output;
		
	}
	add_shortcode( 'ct-agent', 'ct_agent_shortcode' );

	/*-----------------------------------------------------------------------------------*/
	/* Add Agent Shortcode to Visual Composer if the plugin is enabled */
	/*-----------------------------------------------------------------------------------*/

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if(is_plugin_active('js_composer/js_composer.php')) {

		add_action( 'vc_before_init', 'ct_agent_integrateWithVC' );
		function ct_agent_integrateWithVC() {
			$ct_prefix = 'ct_';
			vc_map( array(
			  'name' => __( 'CT Agent', 'contempo' ),
			  'description' => __( 'Display your agents image, name, title &amp; description with a link to their profile.', 'contempo'),
			  'base' => 'ct-agent',
			  'class' => '',
			  'icon' => get_template_directory_uri() . '/images/ct-icon.png',
			  'category' => __( 'CT Modules', 'contempo'),
			  'params' => array(
			    array(
			        'type' => 'textfield',
			        'holder' => 'div',
			        'class' => '',
			        'heading' => __( 'Name', 'contempo' ),
			        'param_name' => $ct_prefix . 'agent_name',
			        'value' => __( '', 'contempo' ),
			        'description' => __( 'Enter the name here.', 'contempo' ),
			        'group' => 'agent'
			    ),
			    array(
			        'type' => 'textfield',
			        'holder' => 'div',
			        'class' => '',
			        'heading' => __( 'Title', 'contempo' ),
			        'param_name' => $ct_prefix . 'agent_title',
			        'value' => __( '', 'contempo' ),
			        'description' => __( 'Enter the title here.', 'contempo' ),
			        'group' => 'agent'
			    ),
			    array(
			        'type' => 'vc_link',
			        'holder' => 'div',
			        'class' => '',
			        'heading' => __( 'Link', 'contempo' ),
			        'param_name' => $ct_prefix . 'agent_link',
			        'value' => __( '', 'contempo' ),
			        'description' => __( 'Enter the URL here, e.g. http://yourlink.com', 'contempo' ),
			        'group' => 'agent'
			    ),
			    array(
			        'type' => 'textarea',
			        'holder' => 'div',
			        'class' => '',
			        'heading' => __( 'Description', 'contempo' ),
			        'param_name' => $ct_prefix . 'agent_description',
			        'value' => __( '', 'contempo' ),
			        'description' => __( 'Enter the description here.', 'contempo' ),
			        'group' => 'agent'
			    ),
	 		    array(
					'type' => 'attach_image',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Image', 'contempo' ),
					'param_name' => $ct_prefix . 'agent_image',
					'value' => __( '', 'contempo' ),
					'description' => __( 'Upload an image here.', 'contempo' ),
					'group' => 'agent'
			    ),
			  )
			) );
		}
	}
}

?>