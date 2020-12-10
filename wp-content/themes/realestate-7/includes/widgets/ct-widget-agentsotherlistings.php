<?php
/**
 * Agents Other Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_AgentsOtherListings')) {
	class ct_AgentsOtherListings extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Display your agents other listings, can only be used in the Listing Single sidebar as it relies on listing information to function properly.' );
			parent::__construct(false, __('CT Agents Other Listings', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) {  
			extract( $args );
			$title = $instance['title'];
			$number = $instance['number'];
			$taxonomy = isset( $instance['taxonomy'] ) ? $instance['taxonomy'] : 'ct_status';
			$tag = isset( $instance['tag'] ) ? $instance['tag'] : 'for-sale';
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . esc_html($title) . $after_title; }
			echo '<ul>';

			global $ct_options;
			$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

			global $post;
			$author = get_the_author_meta('ID');
			$args = array(
	            'post_type' => 'listings', 
	            'order' => 'DSC',
				'author' => $author,
				'post__not_in' => array( $post->ID ),
	            'posts_per_page' => $number,
	            'tax_query' => array(
	            	'tax_query' => array(
		            	'relation' => 'AND',
		            	array(
						    'taxonomy'  => $taxonomy,
						    'field'     => 'slug',
						    'terms'     => $tag,
						    'operator'  => 'IN'
					    ),
					    array(
						    'taxonomy'  => 'ct_status',
						    'field'     => 'slug',
						    'terms'     => 'sold',
						    'operator'  => 'NOT IN'
					    ),
		            )
	            )
			);

			$wp_query_two = new wp_query( $args ); 

			//print_r($wp_query);
	            
	        if ( $wp_query_two->have_posts() ) : while ( $wp_query_two->have_posts() ) : $wp_query_two->the_post(); ?>
	        
	            <li class="listing <?php echo $ct_search_results_listing_style; ?>">
		           	<figure>
		           		<?php
		           			if(has_term('featured', 'ct_status')) {
								echo '<h6 class="snipe featured">';
									echo '<span>';
										echo __('Featured', 'contempo');
									echo '</span>';
								echo '</h6>';
							}
						?>
			            <?php
			            	$status_tags = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'ct_status', '', ' ', '' ) );
			            	$status_tags_stripped = str_replace('_', ' ', $status_tags);
			            	if($status_tags != ''){
								echo '<h6 class="snipe status ';
										$status_terms = get_the_terms( $wp_query_two->post->ID, 'ct_status', array() );
										if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
										    foreach ( $status_terms as $term ) {
										    	echo esc_html($term->slug) . ' ';
										    }
										}
									echo '">';
									echo '<span>';
										echo esc_html($status_tags_stripped);
									echo '</span>';
								echo '</h6>';
							}
						?>
			            <?php ct_property_type_icon(); ?>
		                <?php ct_listing_actions(); ?>
			            <?php ct_first_image_linked(); ?>
			        </figure>
			        <div class="grid-listing-info">
			            <header>
			                <h5 class="marT0 marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
			                <?php
			                	if(taxonomy_exists('city')){
					                $city = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'city', '', ', ', '' ) );
					            }
					            if(taxonomy_exists('state')){
									$state = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'state', '', ', ', '' ) );
								}
								if(taxonomy_exists('zipcode')){
									$zipcode = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'zipcode', '', ', ', '' ) );
								}
								if(taxonomy_exists('country')){
									$country = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'country', '', ', ', '' ) );
								}
							?>
			                <p class="location marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
			            </header>
			            <p class="price marB0"><?php ct_listing_price(); ?></p>
			            <div class="propinfo">
			                <ul class="marB0">
								<?php 
								$ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';
							    $ct_listings_propinfo_property_type = isset( $ct_options['ct_listings_propinfo_property_type'] ) ? esc_html( $ct_options['ct_listings_propinfo_property_type'] ) : '';
							    $ct_listings_propinfo_price_per = isset( $ct_options['ct_listings_propinfo_price_per'] ) ? esc_html( $ct_options['ct_listings_propinfo_price_per'] ) : '';
							    $ct_bed_beds_or_bedrooms = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? esc_html( $ct_options['ct_bed_beds_or_bedrooms'] ) : '';
							    $ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? esc_html( $ct_options['ct_bath_baths_or_bathrooms'] ) : '';
							    $ct_listings_lotsize_format = isset( $ct_options['ct_listings_lotsize_format'] ) ? esc_html( $ct_options['ct_listings_lotsize_format'] ) : '';

							    $ct_property_type = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'property_type', '', ', ', '' ) );
							    $beds = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'beds', '', ', ', '' ) );
							    $baths = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'baths', '', ', ', '' ) );
							    $ct_community = strip_tags( get_the_term_list( $wp_query_two->post->ID, 'community', '', ', ', '' ) );
							    
							    $ct_walkscore = isset( $ct_options['ct_enable_walkscore'] ) ? esc_html( $ct_options['ct_enable_walkscore'] ) : '';
							    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
							    $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

							    if($ct_walkscore == 'yes') {
								    /* Walk Score */
								   	$latlong = get_post_meta($post->ID, "_ct_latlng", true);
								   	$ct_trans_name = uniqid('ct_');

								   	if($latlong != '' && false === ( $ct_ws = get_transient( $ct_trans_name . '_walkscore_data' ) )) {
										list($lat, $long) = explode(',',$latlong,2);
										$address = get_the_title() . ct_taxonomy_return('city') . ct_taxonomy_return('state') . ct_taxonomy_return('zipcode');
										$json = ct_get_walkscore($lat,$long,$address);

										$ct_ws = json_decode($json, true);		

										set_transient( $ct_trans_name . '_walkscore_data', $ct_ws, 7 * DAY_IN_SECONDS );
									}
								}

							    if(ct_has_type('commercial') || ct_has_type('industrial') || ct_has_type('retail') || ct_has_type('lot') || ct_has_type('land')) {  
							        // Dont Display Bed/Bath
							    } else {
							    	if(!empty($beds)) {
								    	echo '<li class="row beds">';
								    		echo '<span class="muted left">';
								    			if($ct_use_propinfo_icons != 'icons') {
								    				if($ct_bed_beds_or_bedrooms == 'rooms') {
										    			_e('Rooms', 'contempo');
										    		} elseif($ct_bed_beds_or_bedrooms == 'bedrooms') {
										    			_e('Bedrooms', 'contempo');
										    		} elseif($ct_bed_beds_or_bedrooms == 'beds') {
										    			_e('Beds', 'contempo');
											    	} else {
											    		_e('Bed', 'contempo');
											    	}
									    		} else {
									    			ct_bed_svg();
									    		}
								    		echo '</span>';
								    		echo '<span class="right">';
								               echo esc_html($beds);
								            echo '</span>';
								        echo '</li>';
								    }	
								    if(!empty($baths)) {
								        echo '<li class="row baths">';
								            echo '<span class="muted left">';
								    			if($ct_use_propinfo_icons != 'icons') {
									    			if($ct_bath_baths_or_bathrooms == 'bathrooms') {
										    			_e('Bathrooms', 'contempo');
										    		} elseif($ct_bath_baths_or_bathrooms == 'baths') {
										    			_e('Baths', 'contempo');
										    		} else {
											    		_e('Bath', 'contempo');
											    	}
									    		} else {
									    			ct_bath_svg();
									    		}
								    		echo '</span>';
								    		echo '<span class="right">';
								               echo esc_html($baths);
								            echo '</span>';
								        echo '</li>';
								    }
							    }
							    
							    if(get_post_meta($post->ID, "_ct_pets", true)) {
								    echo '<li class="row pets">';
										echo '<span class="muted left">';
											if($ct_use_propinfo_icons != 'icons') {
								    			_e('Pets', 'contempo');
								    		} else {
								    			ct_pet_svg();
								    		}
										echo '</span>';
										echo '<span class="right">';
											echo get_post_meta($post->ID, "_ct_pets", true);
								        echo '</span>';
								    echo '</li>';
								}

								if(get_post_meta($post->ID, "_ct_parking", true)) {
								    echo '<li class="row parking">';
										echo '<span class="muted left">';
											if($ct_use_propinfo_icons != 'icons') {
								    			_e('Parking', 'contempo');
								    		} else {
								    			ct_parking_svg();
								    		}
										echo '</span>';
										echo '<span class="right">';
											echo get_post_meta($post->ID, "_ct_parking", true);
								        echo '</span>';
								    echo '</li>';
								}

								include_once ABSPATH . 'wp-admin/includes/plugin.php';
								if(function_exists('pixreviews_init_plugin') && $ct_listing_reviews == 'yes') {
									global $pixreviews_plugin;
									$ct_rating_avg = $pixreviews_plugin->get_average_rating();
									if($ct_rating_avg != '') {
										echo '<li class="row rating">';
								            echo '<span class="muted left">';
								                if($ct_use_propinfo_icons != 'icons') {
									    			_e('Rating', 'contempo');
									    		} else {
									    			ct_star_svg();
									    		}
								            echo '</span>';
								            echo '<span class="right">';
								                 echo esc_html($pixreviews_plugin->get_average_rating());
								            echo '</span>';
								        echo '</li>';
								    }
								}

							    if($ct_rentals_booking == 'yes' || class_exists('Booking_Calendar')) {
								    if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
								        echo '<li class="row guests">';
								            echo '<span class="muted left">';
								                if($ct_use_propinfo_icons != 'icons') {
									    			_e('Guests', 'contempo');
									    		} else {
									    			ct_group_svg();
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
									    			ct_calendar_svg();
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
												 $value = get_post_meta($post->ID, "_ct_sqft", true);
												 if(is_numeric($value)) {
													 echo number_format_i18n($value, 0);
												 } else {
												 	echo esc_html($value);
												 }
								            echo '</span>';
								        echo '</li>';
								    } else {
								    	echo '<li class="row sqft">';
								            echo '<span class="muted left">';
									            ct_size_svg();
								    		echo '</span>';
								    		echo '<span class="right">';
								                 echo number_format_i18n(get_post_meta($post->ID, "_ct_sqft", true), 0);
								                 echo ' ' . ct_sqftsqm();
								            echo '</span>';
								        echo '</li>';
								    }
							    }

							    $price_meta = get_post_meta(get_the_ID(), '_ct_price', true);
								$price_meta= preg_replace('/[\$,]/', '', $price_meta);

								$ct_sqft = get_post_meta(get_the_ID(), '_ct_sqft', true);

							    if(has_term('for-rent', 'ct_status') || has_term('rental', 'ct_status') || has_term('leased', 'ct_status') || has_term('lease', 'ct_status') || has_term('let', 'ct_status') || has_term('sold', 'ct_status')) {
							    	// Do Nothing
							    } elseif($ct_listings_propinfo_price_per != 'yes' && !empty($price_meta) && !empty($ct_sqft)) {
								    echo '<li class="row price-per">';
										echo '<span class="muted left">';
											if($ct_use_propinfo_icons != 'icons') {
								    			_e('Price Per', 'contempo');
												ct_sqftsqm();
								    		} else {
								    			ct_price_per_sqftsqm_svg();
								    		}
										echo '</span>';
										echo '<span class="right">';
											ct_listing_price_per_sqft();
								        echo '</span>';
								    echo '</li>';
								}
							    
							    if(get_post_meta($post->ID, "_ct_lotsize", true)) {
							        if(get_post_meta($post->ID, "_ct_lotsize", true)) {
							            echo '<li class="row lotsize">';
							        }
							            echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Lot Size', 'contempo');
								    		} else {
								    			ct_lotsize_svg();
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							    			if($ct_listings_lotsize_format == 'yes') {
								                 echo number_format_i18n(get_post_meta($post->ID, "_ct_lotsize", true), 0) . ' ';
								            } else {
								             	echo get_post_meta($post->ID, "_ct_lotsize", true) . ' ';
								            }
							                ct_acres();
							            echo '</span>';
							            
							        if((get_post_meta($post->ID, "_ct_lotsize", true))) {
							            echo '</li>';
							        }
							    }

							    if($ct_walkscore == 'yes' && $ct_ws['status'] == 1) {
									echo '<li class="row walkscore">';
							            echo '<span class="muted left">';
							                if($ct_use_propinfo_icons != 'icons') {
								    			_e('Walk Score&reg;', 'contempo');
								    		} else {
								    			ct_walkscore_svg();
								    		}
							            echo '</span>';
							            echo '<span class="right" data-tooltip="' . $ct_ws['description'] . '">';
											echo '<a href="' . $ct_ws['ws_link'] . '" target="_blank">';
												echo esc_html($ct_ws['walkscore']);
											echo '</a>';
							            echo '</span>';
							        echo '</li>';
								}

								if(!empty($ct_community)) {
							    	echo '<li class="row community">';
							    		echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			ct_community_neighborhood_or_district();
								    		} else {
								    			ct_group_svg();
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo esc_html($ct_community);
							            echo '</span>';
							        echo '</li>';
							    }

							    if(!empty($ct_property_type) && $ct_listings_propinfo_property_type != 'yes') {
							        echo '<li class="row property-type">';
							            echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Type', 'contempo');
								    		} else {
								    			if(ct_has_type('commercial') || ct_has_type('industrial') || ct_has_type('retail')) { 
													ct_building_svg();
												} elseif(ct_has_type('land') || ct_has_type('lot')) { 
													ct_tree_svg();
												} else {
													ct_property_type_svg();
												}
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo esc_html($ct_property_type);
							            echo '</span>';
							        echo '</li>';
							    }
								?>
		                    </ul>
	                    </div>
	                    <?php ct_listing_creation_date(); ?>
	                    <?php ct_listing_grid_agent_info(); ?>
	                    <?php ct_brokered_by(); ?>
	                    	<div class="clear"></div>
			        </div>
	            </li>

	        <?php endwhile; endif; wp_reset_postdata(); ?>
			
			<?php echo '</ul>'; ?>
			
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
			
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
			$taxonomy = isset( $instance['taxonomy'] ) ? esc_attr( $instance['taxonomy'] ) : '';
			$tag = isset( $instance['tag'] ) ? esc_attr( $instance['tag'] ) : '';
			
			?>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
	            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number:','contempo'); ?></label>
	            <select name="<?php echo esc_attr($this->get_field_name('number')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>">
	                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
	                <option value="<?php echo esc_attr($i); ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo esc_html($i); ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>"><?php esc_html_e('Taxonomy:','contempo'); ?></label>
	            <select name="<?php echo esc_attr($this->get_field_name('taxonomy')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>">
	                <?php
					foreach (get_object_taxonomies( 'listings', 'objects' ) as $tax => $value) { ?>
	                	<option value="<?php echo esc_attr($tax); ?>" <?php if($taxonomy == $tax){ echo "selected='selected'";} ?>><?php echo esc_html($tax); ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('tag')); ?>"><?php esc_html_e('Tag:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('tag')); ?>"  value="<?php echo esc_attr($tag); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('tag')); ?>" />
			</p>
			<?php
		}
	} 
}

register_widget('ct_AgentsOtherListings');
?>