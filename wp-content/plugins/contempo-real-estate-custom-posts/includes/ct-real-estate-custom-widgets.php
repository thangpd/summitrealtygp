<?php

function wpb_load_widget() {
    register_widget( 'ct_AdWidget' );
    register_widget( 'ct_AgentInfo' );
    register_widget( 'ct_AgentsOtherListings' );
    register_widget( 'ct_BlogAuthorInfo' );
    register_widget( 'ct_BrokerInfo' );
    register_widget( 'ct_ContactInfo' );
    register_widget( 'ct_Latest' );
    register_widget( 'ct_ListingBookShowing' );
    register_widget( 'ct_Listings' );
    register_widget( 'ct_ListingsContact' );
    register_widget( 'ct_ScrollToListingContact' );
    register_widget( 'ct_ListingsSearch' );
    register_widget( 'ct_ListingsSocial' );
    register_widget( 'ct_Search' );
    register_widget( 'ct_Tabs' );
    register_widget( 'ct_Testimonials' );
    register_widget( 'ct_Social' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

/**
 * Adspace
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_AdWidget')) {
	class ct_AdWidget extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Use this widget to add any type of Ad as a widget.' );
			parent::__construct(false, __('CT Adspace Widget', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) { 
			extract( $args ); 
			$title = $instance['title'];
			$adcode = $instance['adcode'];
			$image = $instance['image'];
			$href = $instance['href'];
			$alt = $instance['alt'];

	        echo $before_widget;

			if($title != '')
				echo $before_title .$title. $after_title;

			echo '<div class="widget-inner">';
			
			if($adcode != ''){
			?>
			
			<?php echo $adcode; ?>
			
			<?php } else { ?>
			
				<a href="<?php echo esc_url($href); ?>"><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_html($alt); ?>" /></a>
		
			<?php
			}

			echo '</div>';
			
			echo $after_widget;

		}

		function update($new_instance, $old_instance) {                
			return $new_instance;
		}

		function form($instance) {  
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$adcode = isset( $instance['adcode'] ) ? esc_attr( $instance['adcode'] ) : '';
			$image = isset( $instance['image'] ) ? esc_attr( $instance['image'] ) : '';
			$href = isset( $instance['href'] ) ? esc_attr( $instance['href'] ) : '';
			$alt = isset( $instance['alt'] ) ? esc_attr( $instance['alt'] ) : '';
			?>
	        <p>
	            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title (optional):','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
	        </p>
			<p>
	            <label for="<?php echo $this->get_field_id('adcode'); ?>"><?php esc_html_e('Ad Code:','contempo'); ?></label>
	            <textarea name="<?php echo $this->get_field_name('adcode'); ?>" class="widefat" id="<?php echo $this->get_field_id('adcode'); ?>"><?php echo $adcode; ?></textarea>
	        </p>
	        <p><strong>or</strong></p>
	        <p>
	            <label for="<?php echo $this->get_field_id('image'); ?>"><?php esc_html_e('Image Url:','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $image; ?>" class="widefat" id="<?php echo $this->get_field_id('image'); ?>" />
	        </p>
	        <p>
	            <label for="<?php echo $this->get_field_id('href'); ?>"><?php esc_html_e('Link URL:','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('href'); ?>" value="<?php echo $href; ?>" class="widefat" id="<?php echo $this->get_field_id('href'); ?>" />
	        </p>
	        <p>
	            <label for="<?php echo $this->get_field_id('alt'); ?>"><?php esc_html_e('Alt text:','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('alt'); ?>" value="<?php echo $alt; ?>" class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" />
	        </p>
	        <?php
		}
	} 
}

/**
 * Agent Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
if(!function_exists('ct_AgentInfo')) {
	class ct_AgentInfo extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Use this widget to display your listing agent information, can only be used in the Listing Single sidebar as it relies on listing information for content.' );
		   parent::__construct(false, __('CT Agent Info', 'contempo'),$widget_ops);    
	   }

	   function widget($args, $instance) {  
		extract( $args );
		
		$title = $instance['title'];
		
		?>
			<?php
			
	        echo $before_widget;
			
			if ($title) {
				echo $before_title . $title . $after_title;
			}     

			$author_id = get_the_author_meta('ID');

			echo '<div class="widget-inner">';   
	        
				if(get_the_author_meta('ct_profile_url')) {
					echo '<figure class="col span_12 first row">';
						echo '<a href="' . get_author_posts_url($author_id) . '">';
							echo '<img class="authorimg" src="';
								echo aq_resize(the_author_meta('ct_profile_url'),120);
							echo '" />';
						echo '</a>';
					echo '</figure>';
				} else {
					echo '<a href="' . get_author_posts_url($author_id) . '">';
							echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
					echo '</a>';
				}
					$author_id = get_the_author_meta('ID');
					$first_name = get_the_author_meta('first_name');
					$last_name = get_the_author_meta('last_name');
					$tagline = get_the_author_meta('tagline');
					$mobile = get_the_author_meta('mobile');
					$office = get_the_author_meta('office');
					$fax = get_the_author_meta('fax');
					$email = get_the_author_meta('email');
					$twitterhandle = get_the_author_meta('twitterhandle');
		            $facebookurl = get_the_author_meta('facebookurl');
		            $instagramurl = get_the_author_meta('instagramurl');
		            $linkedinurl = get_the_author_meta('linkedinurl');
		            $youtubeurl = get_the_author_meta('youtubeurl');
				?>
			    
			    <div class="details col span_12 first row">
			        <h5 class="author <?php if(empty($tagline)) { echo 'marB10'; } ?>"><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?></a></h5>
			        <?php if($tagline) { ?>
			            <p class="muted tagline"><i><?php echo esc_html($tagline); ?></i></p>
			        <?php } ?>
			        <ul class="marB0">
			            <?php if($mobile) { ?>
				            <li class="marT3 marB0 row"><span class="muted left"><?php esc_html_e('Mobile', 'contempo'); ?></span><span class="right"><?php echo esc_html($mobile); ?></span></li>
			            <?php } ?>
			            <?php if($office) { ?>
				            <li class="marT3 marB0 row"><span class="muted left"><?php esc_html_e('Office', 'contempo'); ?></span><span class="right"><?php echo esc_html($office); ?></span></li>
			            <?php } ?>
			            <?php if($fax) { ?>
				            <li class="marT3 marB0 row"><span class="muted left"><?php esc_html_e('Fax', 'contempo'); ?></span><span class="right"><?php echo esc_html($fax); ?></span></li>
				        <?php } ?>
			        	<?php if($email) { ?>
				        	<li class="marT3 marB0 row"><span class="muted left"><i class="fa fa-envelope"></i></span><span class="right"><a href="mailto:<?php echo antispambot($email,1) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
					    <?php } ?>
					</ul>

					<ul class="social marT15 marL0">
	                    <?php if ($twitterhandle) { ?><li class="twitter"><a href="https://twitter.com/#!/<?php echo esc_html($twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
	                    <?php if ($facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
	                    <?php if ($instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
	                    <?php if ($linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
	                    <?php if ($youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
	                </ul>
			    </div>
				    <div class="clear"></div>
		    </div>
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) { 
			
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			
			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
		<?php }
	} 
}

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
			$taxonomy = $instance['taxonomy'];
			$tag = $instance['tag'];
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
				$taxonomy => $tag,
				'author' => $author,
				'post__not_in' => array( $post->ID ),
	            'posts_per_page' => $number,
	            'tax_query' => array(
	            	array(
					    'taxonomy'  => 'ct_status',
					    'field'     => 'slug',
					    'terms'     => 'ghost', 
					    'operator'  => 'NOT IN'
				    ),
	            )
			);

			$wp_query = new wp_query( $args ); 
	            
	        if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
	        
	            <li class="listing <?php echo $ct_search_results_listing_style; ?>">
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
			            	$status_tags = strip_tags( get_the_term_list( $wp_query->post->ID, 'ct_status', '', ' ', '' ) );
			            	$status_tags_stripped = str_replace('_', ' ', $status_tags);
			            	if($status_tags != ''){
								echo '<h6 class="snipe status ';
										$status_terms = get_the_terms( $wp_query->post->ID, 'ct_status', array() );
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
							?>
			                <p class="location marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
			            </header>
			            <p class="price marB0"><?php ct_listing_price(); ?></p>
			            <div class="propinfo">
			                <ul class="marB0">
								<?php
								global $ct_options;

								$ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';

								$beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
							    $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

							    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
							    $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

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

							    if($ct_listing_reviews == 'yes' || class_exists('PixReviewsPlugin')) {
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

							    if($ct_rentals_booking == 'yes' || class_exists('Booking_Calendar')) {
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
							    }
								?>
									<div class="clear"></div>
		                    </ul>
	                    </div>
	                    <?php ct_listing_creation_date(); ?>
	                    <?php ct_brokered_by(); ?>
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
		   
			$taxonomies = array (
				'property_type' => 'property_type',
				'beds' => 'beds',
				'baths' => 'baths',
				'status' => 'status',
				'city' => 'city',
				'state' => 'state',
				'zipcode' => 'zipcode',
				'additional_features' => 'additional_features'
			);
			
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
			$taxonomy = isset( $instance['taxonomy'] ) ? esc_attr( $instance['taxonomy'] ) : '';
			$tag = isset( $instance['tag'] ) ? esc_attr( $instance['tag'] ) : '';
			
			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
			<p>
	            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number:','contempo'); ?></label>
	            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
	                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
	                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
	            <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php esc_html_e('Taxonomy:','contempo'); ?></label>
	            <select name="<?php echo $this->get_field_name('taxonomy'); ?>" class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>">
	                <?php
					foreach ($taxonomies as $tax => $value) { ?>
	                <option value="<?php echo $tax; ?>" <?php if($taxonomy == $tax){ echo "selected='selected'";} ?>><?php echo $tax; ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
			   <label for="<?php echo $this->get_field_id('tag'); ?>"><?php esc_html_e('Tag:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('tag'); ?>"  value="<?php echo $tag; ?>" class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" />
			</p>
			<?php
		}
	} 
}

/**
 * Blog Author Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_BlogAuthorInfo')) {
	class ct_BlogAuthorInfo extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'This is a Blog Author Info widget.' );
		   parent::__construct(false, __('CT Blog Author Info', 'contempo'),$widget_ops);      
	   }

	   function widget($args, $instance) {  
		extract( $args );
		$title = $instance['title'];
		$bio = $instance['bio'];
		$custom_email = $instance['custom_email'];
		$avatar_size = $instance['avatar_size']; if ( !$avatar_size ) $avatar_size = 48;
		$avatar_align = $instance['avatar_align']; if ( !$avatar_align ) $avatar_align = 'left';
		$read_more_text = $instance['read_more_text'];
		$read_more_url = $instance['read_more_url'];
		$page = $instance['page'];
		if ( ( $page == "home" && is_home() ) || ( $page == "single" && is_single() ) || $page == "all" ) {
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; }

			echo '<div class="widget-inner">'; ?>
			
				<span class="<?php echo esc_html($avatar_align); ?>"><?php if ( $custom_email ) echo get_avatar( $custom_email, $size = $avatar_size ); ?></span>
				<p><?php echo esc_html($bio); ?></p>
				<?php if ( $read_more_url ) echo '<p class="right"><a class="read-more" href="' . esc_url($read_more_url) . '">' . esc_html($read_more_text) . '<em>&rarr;</em></a></p>'; ?>

				<?php echo '</div>'; ?>
			<?php echo $after_widget; ?>   
	    <?php
		}
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
		   
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$bio = isset( $instance['bio'] ) ? esc_attr( $instance['bio'] ) : '';
			$custom_email = isset( $instance['custom_email'] ) ? esc_attr( $instance['custom_email'] ) : '';
			$avatar_size = isset( $instance['avatar_size'] ) ? esc_attr( $instance['avatar_size'] ) : '';
			$avatar_align = isset( $instance['avatar_align'] ) ? esc_attr( $instance['avatar_align'] ) : '';
			$read_more_text = isset( $instance['read_more_text'] ) ? esc_attr( $instance['read_more_text'] ) : '';
			$read_more_url = isset( $instance['read_more_url'] ) ? esc_attr( $instance['read_more_url'] ) : '';
			$page = isset( $instance['page'] ) ? esc_attr( $instance['page'] ) : '';

			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('bio'); ?>"><?php esc_html_e('Bio:','contempo'); ?></label>
				<textarea name="<?php echo $this->get_field_name('bio'); ?>" class="widefat" id="<?php echo $this->get_field_id('bio'); ?>"><?php echo $bio; ?></textarea>
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('custom_email'); ?>"><?php esc_html_e('<a href="http://www.gravatar.com/">Gravatar</a> E-mail:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('custom_email'); ?>"  value="<?php echo $custom_email; ?>" class="widefat" id="<?php echo $this->get_field_id('custom_email'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php esc_html_e('Gravatar Size:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('avatar_size'); ?>"  value="<?php echo $avatar_size; ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('avatar_align'); ?>"><?php esc_html_e('Gravatar Alignment:','contempo'); ?></label>
				<select name="<?php echo $this->get_field_name('avatar_align'); ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_align'); ?>">
					<option value="left" <?php if($avatar_align == "left"){ echo "selected='selected'";} ?>><?php esc_html_e('Left', 'contempo'); ?></option>
					<option value="right" <?php if($avatar_align == "right"){ echo "selected='selected'";} ?>><?php esc_html_e('Right', 'contempo'); ?></option>            
				</select>
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('read_more_text'); ?>"><?php esc_html_e('Read More Text (optional):','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('read_more_text'); ?>"  value="<?php echo $read_more_text; ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_text'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('read_more_url'); ?>"><?php esc_html_e('Read More URL (optional):','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('read_more_url'); ?>"  value="<?php echo $read_more_url; ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_url'); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('page'); ?>"><?php esc_html_e('Visible Pages:','contempo'); ?></label>
				<select name="<?php echo $this->get_field_name('page'); ?>" class="widefat" id="<?php echo $this->get_field_id('page'); ?>">
					<option value="all" <?php if($page == "all"){ echo "selected='selected'";} ?>><?php esc_html_e('All', 'contempo'); ?></option>
					<option value="home" <?php if($page == "home"){ echo "selected='selected'";} ?>><?php esc_html_e('Home only', 'contempo'); ?></option>            
					<option value="single" <?php if($page == "single"){ echo "selected='selected'";} ?>><?php esc_html_e('Single only', 'contempo'); ?></option>            
				</select>
			</p>
			<?php
		}
	} 
}

/**
 * Broker Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_BrokerInfo')) {
	class ct_BrokerInfo extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Use this widget to display your brokers information.' );
		   parent::__construct(false, __('CT Brokers Info', 'contempo'),$widget_ops);      
	   }

	   function widget($args, $instance) {  
		extract( $args );

		$title = $instance['title'];
		$logo = $instance['logo'];
		$company = $instance['company'];
		$office_phone = $instance['office_phone'];
		$office_email = $instance['office_email'];
		$website = $instance['website'];
		
		?>
			<?php
	        
			echo $before_widget;
			
			if ($title) {
				echo $before_title . $title . $after_title;
			}

			echo '<div class="widget-inner">';
	        
				if($logo) {
					echo '<figure class="col span_3">';
					if(!empty($website)) {
						echo '<a href="' . $website . '" target="_blank">';
						echo '<img class="left marR10" src="' . $logo . '" />';
						echo '</a>';
					} else {
						 echo '<img class="left marR10" src="' . $logo . '" />';
					}
					echo '</figure>';
				} ?>
		        
		        <div class="details col span_8">
					<?php if($company != "") {
						echo '<h5 class="author marB5">' . esc_html($company) . '</h5>';
		            } ?>
					<?php if($office_phone != "") { ?><p class="marB0"><?php echo esc_html($office_phone); ?></p><?php } ?>
		            <?php if($office_email != "") { ?><p class="marT3 marB0"><a href="mailto:<?php echo esc_html($office_email); ?>"><?php esc_html_e('Email Office', 'contempo'); ?></a></p><?php } ?>
		            <?php if($website != "") { ?><p class="marT3 marB0"><a href="<?php echo esc_url($website); ?>" target="_blank"><?php esc_html_e('Visit Brokers Website', 'contempo'); ?></a></p><?php } ?>
		        </div>
		        
	        </div>
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) { 

			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$logo = isset( $instance['logo'] ) ? esc_attr( $instance['logo'] ) : '';
			$company = isset( $instance['company'] ) ? esc_attr( $instance['company'] ) : '';
			$office_phone = isset( $instance['office_phone'] ) ? esc_attr( $instance['office_phone'] ) : '';
			$office_email = isset( $instance['office_email'] ) ? esc_attr( $instance['office_email'] ) : '';
			$website = isset( $instance['website'] ) ? esc_attr( $instance['website'] ) : '';
			
			?>
	        <p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('logo'); ?>"><?php esc_html_e('Logo URL:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('logo'); ?>"  value="<?php echo $logo; ?>" class="widefat" id="<?php echo $this->get_field_id('logo'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('company'); ?>"><?php esc_html_e('Company:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('company'); ?>"  value="<?php echo $company; ?>" class="widefat" id="<?php echo $this->get_field_id('company'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('office_phone'); ?>"><?php esc_html_e('Office Phone:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('office_phone'); ?>"  value="<?php echo $office_phone; ?>" class="widefat" id="<?php echo $this->get_field_id('office_phone'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('office_email'); ?>"><?php esc_html_e('Office Email:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('office_email'); ?>"  value="<?php echo $office_email; ?>" class="widefat" id="<?php echo $this->get_field_id('office_email'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('website'); ?>"><?php esc_html_e('Website:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('website'); ?>"  value="<?php echo $website; ?>" class="widefat" id="<?php echo $this->get_field_id('website'); ?>" />
			</p>
		<?php }
	} 
}

/**
 * Contact Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ContactInfo')) {
	class ct_ContactInfo extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Use this widget to display your contact information.' );
		   parent::__construct(false, __('CT Contact Info', 'contempo'),$widget_ops);      
	   }

	   function widget($args, $instance) {  
		extract( $args );
		global $ct_options;
		$title = $instance['title'];
		$logo = $instance['logo'];
		$ct_logo = isset( $ct_options['ct_logo']['url'] ) ? esc_html( $ct_options['ct_logo']['url'] ) : '';
		$ct_logo_highres = isset( $ct_options['ct_logo_highres']['url'] ) ? esc_html( $ct_options['ct_logo_highres']['url'] ) : '';
		$blurb = $instance['blurb'];
		$company = $instance['company'];
		$street = $instance['street'];
		$city = $instance['city'];
		$state = $instance['state'];
		$postal = $instance['postal'];
		$country = $instance['country'];
		$phone = $instance['phone'];
		$email = $instance['email'];
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$linkedin = $instance['linkedin'];
		$instagram = $instance['instagram'];
		$pinterest = $instance['pinterest'];

		global $ct_options;
		?>

			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; }
			echo '<div class="widget-inner">';
				if($logo == "Yes") { ?>
					<?php if(!empty($ct_options['ct_logo']['url'])) { ?>
						<a href="<?php echo home_url(); ?>"><img class="widget-logo marB30" src="<?php echo esc_url($ct_logo); ?>" <?php if(!empty($ct_logo_highres)) { ?>srcset="<?php echo esc_url($ct_logo_highres); ?> 2x"<?php } ?> alt="<?php bloginfo('name'); ?>" /></a>
					<?php } else { ?>
						<?php if($ct_options['ct_skin'] == 'minimal') { ?>
	                        <img class="widget-logo marB30" src="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo-blue.png" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo-blue@2x.png 2x" alt="WP Pro Real Estate 7, a WordPress theme by Contempo" />
	                    <?php } else { ?>
	                    	<img class="widget-logo marB30" src="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo.png" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo@2x.png 2x" alt="WP Pro Real Estate 7, a WordPress theme by Contempo" />
	                    <?php } ?>
					<?php } ?>
				<?php } ?>
				<?php
				$ct_allowed_html = array(
		                'a' => array(
		                    'href' => array(),
		                    'title' => array()
		                ),
		                'img' => array(
		                    'src' => array(),
		                    'alt' => array()
		                ),
		                'em' => array(),
		                'strong' => array(),
		            );
	            ?>
		        <?php if($blurb) { ?><p class="marB15"><?php echo wp_kses(stripslashes($blurb), $ct_allowed_html); ?></p><?php } ?>

		        <ul class="contact-info">
		            <?php if(!empty($street)) { ?>
		            	<li class="company-address"><i class="fa fa-home"></i> <?php echo esc_html($street); ?><br />
		            
			            <?php if(!empty($city) || !empty($city) || !empty($city) || !empty($city) || !empty($city)) { ?>
				            <?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($postal); ?><br /><?php echo esc_html($country); ?>
				        <?php } ?>

				        </li>
				    <?php } ?>
		            <?php if($phone) { ?><li class="company-phone"><i class="fa fa-phone"></i> <?php echo esc_html($phone); ?></li><?php } ?>
		            <?php if($email) { ?><li class="company-email"><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo antispambot($email); ?>"><?php echo antispambot($email); ?></a></li><?php } ?>
		        </ul>

		        <ul class="contact-social">
					<?php if($facebook != '') { ?>
		                <li class="facebook"><a href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook"></i></a></li>
		            <?php } ?>
		            <?php if($twitter != '') { ?>
		                <li class="twitter"><a href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter"></i></a></li>
		            <?php } ?>
		            <?php if($linkedin != '') { ?>
		                <li class="linkedin"><a href="<?php echo esc_url($linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
		            <?php } ?>
		            <?php if($pinterest != '') { ?>
		                <li class="pinterest"><a href="<?php echo esc_url($pinterest); ?>"><i class="fa fa-pinterest"></i></a></li>
		            <?php } ?>
		            <?php if($instagram != '') { ?>
		                <li class="instagram"><a href="<?php echo esc_url($instagram); ?>"><i class="fa fa-instagram"></i></a></li>
		            <?php } ?>
		        </ul>
		    </div>
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {    
	   
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';    
			$blurb = isset( $instance['blurb'] ) ? esc_attr( $instance['blurb'] ) : '';
			$company = isset( $instance['company'] ) ? esc_attr( $instance['company'] ) : '';
			$street = isset( $instance['street'] ) ? esc_attr( $instance['street'] ) : '';
			$city = isset( $instance['city'] ) ? esc_attr( $instance['city'] ) : '';
			$state = isset( $instance['state'] ) ? esc_attr( $instance['state'] ) : '';
			$postal = isset( $instance['postal'] ) ? esc_attr( $instance['postal'] ) : '';
			$country = isset( $instance['country'] ) ? esc_attr( $instance['country'] ) : '';
			$phone = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
			$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
			$facebook = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
			$twitter = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
			$linkedin = isset( $instance['linkedin'] ) ? esc_attr( $instance['linkedin'] ) : '';
			$instagram = isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : '';
			$pinterest = isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : '';

			$logo = isset( $instance['logo'] ) ? esc_attr( $instance['logo'] ) : '';

			?>
			<p>
	            <label for="<?php echo $this->get_field_id('logo'); ?>"><?php esc_html_e('Show Logo:','contempo'); ?></label>
	            <select name="<?php echo $this->get_field_name('logo'); ?>" class="widefat" id="<?php echo $this->get_field_id('logo'); ?>">
	                <option value="Yes" <?php if($logo == 'Yes'){ echo "selected='selected'";} ?>><?php esc_html_e('Yes', 'contempo'); ?></option>
	                <option value="No" <?php if($logo == 'No'){ echo "selected='selected'";} ?>><?php esc_html_e('No', 'contempo'); ?></option>
	            </select>
	        </p>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('blurb'); ?>"><?php esc_html_e('Blurb:','contempo'); ?></label>
				<textarea name="<?php echo $this->get_field_name('blurb'); ?>" class="widefat" id="<?php echo $this->get_field_id('blurb'); ?>"><?php echo $blurb; ?></textarea>
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('company'); ?>"><?php esc_html_e('Company Name:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('company'); ?>"  value="<?php echo $company; ?>" class="widefat" id="<?php echo $this->get_field_id('company'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('street'); ?>"><?php esc_html_e('Street Address:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('street'); ?>"  value="<?php echo $street; ?>" class="widefat" id="<?php echo $this->get_field_id('street'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('city'); ?>"><?php esc_html_e('City:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('city'); ?>"  value="<?php echo $city; ?>" class="widefat" id="<?php echo $this->get_field_id('city'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('state'); ?>"><?php esc_html_e('State:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('state'); ?>"  value="<?php echo $state; ?>" class="widefat" id="<?php echo $this->get_field_id('state'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('postal'); ?>"><?php esc_html_e('Postal:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('postal'); ?>"  value="<?php echo $postal; ?>" class="widefat" id="<?php echo $this->get_field_id('postal'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('country'); ?>"><?php esc_html_e('Country:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('country'); ?>"  value="<?php echo $country; ?>" class="widefat" id="<?php echo $this->get_field_id('country'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('phone'); ?>"><?php esc_html_e('Phone:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('phone'); ?>"  value="<?php echo $phone; ?>" class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('email'); ?>"><?php esc_html_e('Email:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('email'); ?>"  value="<?php echo $email; ?>" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php esc_html_e('Facebook:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php esc_html_e('Twitter:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php esc_html_e('LinkedIn:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>"  value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php esc_html_e('Pinterest:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>"  value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php esc_html_e('Instagram:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>"  value="<?php echo $instagram; ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
			</p>
			<?php
		}
	} 
}

/**
 * Latest Posts
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_Latest')) {
	class ct_Latest extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Display your latest posts.' );
		   parent::__construct(false, __('CT Latest Posts', 'contempo'),$widget_ops);      
	   }

	   function widget($args, $instance) {  
		extract( $args );
		$title = isset( $instance['title'] ) ? esc_html( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? esc_html( $instance['number'] ) : '';
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; }
			echo '<div class="widget-inner">';
				echo '<ul>';
				global $post;
				query_posts(array(
		            'order' => 'DSC',
		            'posts_per_page' => $number
				));
		            
		        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		        
		            <li>
		                <h5 class="marB0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
		                <?php the_excerpt('25'); ?>
		            </li>

		        <?php endwhile; endif; wp_reset_query(); ?>
				
				<?php echo '</ul>'; ?>

			<?php echo '<div class="widget-inner">'; ?>
			
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
		   
			$taxonomies = array (
				'property_type' => 'property_type',
				'beds' => 'beds',
				'baths' => 'baths',
				'status' => 'status',
				'city' => 'city',
				'state' => 'state',
				'zipcode' => 'zipcode',
				'additional_features' => 'additional_features'
			);
	   
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';

			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
			<p>
	            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number:','contempo'); ?></label>
	            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
	                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
	                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
	                <?php } ?>
	            </select>
	        </p>
			<?php
		}
	} 
}

/**
 * Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_Listings')) {
	class ct_Listings extends WP_Widget {

		function __construct() {
		   $widget_ops = array('description' => 'Display your latest listings.' );
		   parent::__construct(false, __('CT Listings', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) {  
			extract( $args );
			$title = $instance['title'];
			$number = $instance['number'];
			$taxonomy = $instance['taxonomy'];
			$tag = $instance['tag'];
			$viewalltext = $instance['viewalltext'];
			$viewalllink = $instance['viewalllink'];
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; }

			echo '<ul>';

			global $ct_options;
			$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

			global $post;
			global $wp_query;

	        wp_reset_postdata();
			
			$args = array(
	            'post_type' => 'listings', 
	            'order' => 'DSC',
				$taxonomy => $tag,
	            'posts_per_page' => $number,
	            'tax_query' => array(
	            	array(
					    'taxonomy'  => 'ct_status',
					    'field'     => 'slug',
					    'terms'     => 'ghost',
					    'operator'  => 'NOT IN'
				    ),
	            )
			);
			$wp_query = new wp_query( $args ); 
	            
	        if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
	        
	            <li class="listing <?php echo $ct_search_results_listing_style; ?>">
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
			            	$status_tags = strip_tags( get_the_term_list( $wp_query->post->ID, 'ct_status', '', ' ', '' ) );
			            	$status_tags_stripped = str_replace('_', ' ', $status_tags);
			            	if($status_tags != ''){
								echo '<h6 class="snipe status ';
										$status_terms = get_the_terms( $wp_query->post->ID, 'ct_status', array() );
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
			                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
			                <p class="location marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?><?php country(); ?></p>
			            </header>
			            <p class="price marB0"><?php ct_listing_price(); ?></p>
			            <ul class="propinfo marB0">
			            	<?php ct_propinfo(); ?>
			            </ul>
			            <?php ct_listing_creation_date(); ?>
			            <?php ct_brokered_by(); ?>
	                    <div class="clear"></div>
	            </li>

	        <?php endwhile; endif; wp_reset_postdata(); ?>
			
			<?php echo '</ul>'; ?>
	        
	           <?php if($viewalltext) { ?>
	               <p id="viewall"><a class="read-more right" href="<?php echo esc_url($viewalllink); ?>"><?php echo esc_html($viewalltext); ?> <em>&rarr;</em></a></p>
	           <?php } ?>
			
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
			$viewalltext = isset( $instance['viewalltext'] ) ? esc_attr( $instance['viewalltext'] ) : '';
			$viewalllink = isset( $instance['viewalllink'] ) ? esc_attr( $instance['viewalllink'] ) : '';
			
			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
			<p>
	            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number:','contempo'); ?></label>
	            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
	                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
	                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
	            <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php esc_html_e('Taxonomy:','contempo'); ?></label>
	            <select name="<?php echo $this->get_field_name('taxonomy'); ?>" class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>">
	                <?php
					foreach (get_object_taxonomies( 'listings', 'objects' ) as $tax => $value) { ?>
	                <option value="<?php echo $tax; ?>" <?php if($taxonomy == $tax){ echo "selected='selected'";} ?>><?php echo $tax; ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
			   <label for="<?php echo $this->get_field_id('tag'); ?>"><?php esc_html_e('Tag:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('tag'); ?>"  value="<?php echo $tag; ?>" class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('viewalltext'); ?>"><?php esc_html_e('View All Link Text','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('viewalltext'); ?>"  value="<?php echo $viewalltext; ?>" class="widefat" id="<?php echo $this->get_field_id('viewalltext'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('viewalllink'); ?>"><?php esc_html_e('View All Link URL','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('viewalllink'); ?>"  value="<?php echo $viewalllink; ?>" class="widefat" id="<?php echo $this->get_field_id('viewalllink'); ?>" />
			</p>
			<?php
		}
	} 
}

/**
 * Listings Contact Form
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ListingsContact')) {
	class ct_ListingsContact extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Display an agent contact form. Can only be used in the Listing Single sidebar as it relies on listing information for content.' );
		   parent::__construct(false, __('CT Listing Agent Contact', 'contempo'),$widget_ops);      
	   }

	   function widget($args, $instance) {  
		extract( $args );
		$title = $instance['title'];
		$subject = $instance['subject'];
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; }
				global $ct_options;

			echo '<div class="widget-inner">'; ?>
	        
	            <form id="listingscontact" class="formular" method="post">
	                <fieldset>
		                <select id="ctinquiry" name="ctinquiry">
							<option><?php esc_html_e('Tell me more about this property', 'contempo'); ?></option>
							<option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
						</select>
							<div class="clear"></div>
	                    <input type="text" name="name" id="name" class="validate[required] text-input" value="<?php esc_html_e('Name', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Name', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Name', 'contempo'); ?>';" />
	                    
	                    <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" value="<?php esc_html_e('Email', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Email', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Email', 'contempo'); ?>';" />
	                    
	                    <input type="text" name="ctphone" id="ctphone" class="text-input" value="<?php esc_html_e('Phone', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Phone', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Phone', 'contempo'); ?>';" />
	                    
	                    <textarea class="validate[required,length[2,500]] text-input" name="message" id="message" rows="5" cols="10"></textarea>
	                    
	                    <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php the_author_meta('user_email'); ?>" />
	                    <input type="hidden" id="ctproperty" name="ctproperty" value="<?php ct_listing_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
	                    <input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />
	                    <input type="hidden" id="ctsubject" name="ctsubject" value="<?php echo esc_html($subject); ?>" />
	                    
	                    <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
	                </fieldset>
	            </form>

	        <?php echo '</div>'; ?>
			
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
			
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$subject = isset( $instance['subject'] ) ? esc_attr( $instance['subject'] ) : '';
			
			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('subject'); ?>"><?php esc_html_e('Subject:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('subject'); ?>"  value="<?php echo $subject; ?>" class="widefat" id="<?php echo $this->get_field_id('subject'); ?>" />
			</p>
			<?php
		}
	} 
}

/**
 * ScrollTo Listing Contact
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ScrollToListingContact')) {
	class ct_ScrollToListingContact extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Use this widget to add a simple button with smoothscroll to the listing contact form.' );
			parent::__construct(false, __('CT Listing Contact ScrollTo', 'contempo'), $widget_ops);      
		}

		function widget($args, $instance) { 
			extract( $args ); 

			$title = $instance['title'];

			$buttononetext = $instance['buttononetext'];
			$buttontwotext = $instance['buttontwotext'];

	        echo $before_widget;

			if($title != '')

				echo $before_title .$title. $after_title;

			echo '<div class="widget-inner">';
			
				// Button One
				if(!empty($buttononetext)) {
				
					echo '<a class="btn" href="#listing-contact">' . $buttononetext . '</a>';
			
				}

				// Button Two
				if(!empty($buttontwotext)) {
				
					echo '<a class="btn btn-secondary marT20" href="#listing-contact">' . $buttontwotext . '</a>';
			
				}

			echo '</div>';
			
			echo $after_widget;

		}

		function update($new_instance, $old_instance) {                
			return $new_instance;
		}

		function form($instance) {  
				$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
				$buttononetext = $instance['buttononetext'];
				$buttontwotext = $instance['buttontwotext'];
			?>
	        <p>
	            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title (optional):','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
	        </p>
			<p>
	            <label for="<?php echo $this->get_field_id('buttononetext'); ?>"><?php esc_html_e('Button One Text:','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('buttononetext'); ?>" value="<?php echo $buttononetext; ?>" class="widefat" id="<?php echo $this->get_field_id('buttononetext'); ?>" />
	        </p>
	        <p>
	            <label for="<?php echo $this->get_field_id('buttontwotext'); ?>"><?php esc_html_e('Button Two Text:','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('buttontwotext'); ?>" value="<?php echo $buttontwotext; ?>" class="widefat" id="<?php echo $this->get_field_id('buttontwotext'); ?>" />
	        </p>
	        <?php
		}
	} 
}

/**
 * Listings Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ListingsSearch')) {
    class ct_ListingsSearch extends WP_Widget {

       function __construct() {
    	   $widget_ops = array('description' => 'Display the listings search.' );
    	   parent::__construct(false, __('CT Listings Search', 'contempo'),$widget_ops);      
       }

       function widget($args, $instance) {  
    	extract( $args );
    	
    	$title = $instance['title'];

    	global $ct_options;

        $ct_home_adv_search_fields = isset( $ct_options['ct_home_adv_search_fields']['enabled'] ) ? $ct_options['ct_home_adv_search_fields']['enabled'] : '';
        $ct_enable_adv_search_page = isset( $ct_options['ct_enable_adv_search_page'] ) ? $ct_options['ct_enable_adv_search_page'] : '';
        $ct_adv_search_page = isset( $ct_options['ct_adv_search_page'] ) ? $ct_options['ct_adv_search_page'] : '';
    	
    	?>
    		<?php echo $before_widget; ?>
    		<?php if ($title) { echo $before_title . $title . $after_title; }

            echo '<div class="widget-inner">'; ?>
            
                <form id="advanced_search" name="search-listings" action="<?php echo home_url(); ?>">

                   <?php
            
                    if ($ct_home_adv_search_fields) :
                    
                    foreach ($ct_home_adv_search_fields as $field=>$value) {
        
                        switch($field) {
                            
                        // Type            
                        case 'type' : ?>
                            <div class="left">
                                <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
                                <?php ct_search_form_select('property_type'); ?>
                            </div>
                        <?php
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

                        // Country            
                        case 'county' : ?>
                            <div class="left">
                                <label for="ct_county"><?php _e('County', 'contempo'); ?></label>
                                <?php ct_search_form_select('county'); ?>
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
                        case 'price_from' : ?>
                            <div class="left">
                                <label for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" />
                            </div>
                        <?php
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
                                <?php if(class_exists('IDX')) { ?>
                                    <label for="ct_mls"><?php _e('MLS ID', 'contempo'); ?></label>
                                    <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('MLS ID', 'contempo'); ?>" />
                                <?php } else { ?>
                                    <label for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
                                    <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" />
                                <?php } ?>
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

                        }
                    
                    } endif; ?>
                    
                        <div class="clear"></div>
                    
                    <input type="hidden" name="search-listings" value="true" />
                    <?php
        		        if(class_exists('SitePress')) {

        		            $lang =  ICL_LANGUAGE_CODE;

        		            //echo '<input type="hidden" name="lang" value="' . $lang . '" />';
        		        }
        		    ?>
                    <input id="submit" class="btn marB0" type="submit" value="<?php esc_html_e('Search', 'contempo'); ?>" />

                    <?php if($ct_enable_adv_search_page == 'yes' && $ct_adv_search_page != '') { ?>
                    <div class="left">
                        <a class="btn more-search-options" href="<?php echo home_url(); ?>/?page_id=<?php echo esc_html($ct_adv_search_page); ?>"><?php _e('More Search Options', 'contempo'); ?></a>
                    </div>
                    <?php } ?>

                    <div class="left makeloading"><i class="fa fa-circle-o-notch fa-spin"></i></div>

                </form>

            </div>
    		
    		<?php echo $after_widget; ?>   
        <?php
       }

       function update($new_instance, $old_instance) {                
    	   return $new_instance;
       }

       function form($instance) {

    		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

    		?>
    		<p>
    		   <label class="muted" for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
    		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
    		</p>
    		<?php
    	}
    } 
}

/**
 * Listings Social
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ListingsSocial')) {
	class ct_ListingsSocial extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Social sharing links, only to be used in the Listing Single sidebar.' );
			parent::__construct(false, __('CT Listings Social', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) { 
			extract( $args ); 
			$title = $instance['title'];

	        echo $before_widget;

			if($title != '')
				echo $before_title .$title. $after_title;
			?>

			<div class="widget-inner">

				<ul class="social marB0">
			        <li class="twitter"><a href="javascript:void(0);" onclick="popup('https://twitter.com/home/?status=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?> &mdash; <?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
			        <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
			        <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
			    </ul>

			</div>

			<?php echo $after_widget;

		}

		function update($new_instance, $old_instance) {                
			return $new_instance;
		}

		function form($instance) {  
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			?>
	        <p>
	            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title (optional):','contempo'); ?></label>
	            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
	        </p>
	        <?php
		}
	} 
}

/**
 * Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_Search')) {
  class ct_Search extends WP_Widget {

     function __construct() {
  	   $widget_ops = array('description' => 'This is a search widget.' );
         parent::__construct(false, __('CT Search', 'contempo'),$widget_ops);      
     }

     function widget($args, $instance) {  
      extract( $args );
     	$title = $instance['title'];

        echo $before_widget;
  			if ($title) {
  				echo $before_title . $title . $after_title;
  			}
        echo '<div class="widget-inner">';
    			get_template_part('searchform');
        echo '</div>';
  		echo $after_widget;
     }

     function update($new_instance, $old_instance) {                
         return $new_instance;
     }

     function form($instance) {        
     
         $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

         ?>
         <p>
  	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
  	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
         </p>
        <?php
     }
  } 
}

/**
 * Tabs
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_Tabs')) {
  class ct_Tabs extends WP_Widget {

     function __construct() {
         $widget_ops = array( 'description' => 'It contains the Latest Posts, Recent comments and a Tag cloud.' );
         parent::__construct(false, $name = __( 'CT Tabs', 'contempo' ), $widget_ops);
     }


     function widget($args, $instance) {
         extract( $args );

         $number = @$instance['number']; if ($number == '') $number = 5;
         $order = @$instance['order']; if ($order == '') $order = "latest";
         $latest = @$instance['latest'];
         $comments = @$instance['comments'];
         $tags = @$instance['tags'];
         $pop = isset( $pop ) ? esc_attr( $pop ) : '';
         ?>

      <?php echo $before_widget; ?>

              <ul class="tabs">
                  <?php if ( $order == "latest" && !$latest == "on") { ?><li class="latest"><a href="#tab-latest"><i class="fa fa-clock-o"></i></a></li>
                  <?php } elseif ( $order == "comments" && !$comments == "on") { ?><li class="comments"><a href="#tab-comm"><i class="fa fa-comment"></i></a></li>
                  <?php } elseif ( $order == "tags" && !$tags == "on") { ?><li class="tags"><a href="#tab-tags"><i class="fa fa-tag"></i></a></li>
                  <?php } ?>
                  <?php if ($order <> "latest" && !$latest == "on") { ?><li class="latest"><a href="#tab-latest"><i class="fa fa-clock-o"></i></a></li><?php } ?>
                  <?php if ($order <> "comments" && !$comments == "on") { ?><li class="comments"><a href="#tab-comm"><i class="fa fa-comment"></i></a></li><?php } ?>
                  <?php if ($order <> "tags" && !$tags == "on") { ?><li class="tags"><a href="#tab-tags"><i class="fa fa-tag"></i></a></li><?php } ?>
              </ul>
              
                <div class="clear"></div>

              <div class="inside">

                <?php if ( $order == "latest" && !$latest == "on") { ?>
                  <ul id="tab-latest" class="list">
                      <?php if ( function_exists( 'ct_widget_tabs_latest') ) ct_widget_tabs_latest($number); ?>
                  </ul>
                <?php } elseif ( $order == "comments" && !$comments == "on") { ?>
                <ul id="tab-comm" class="list">
                      <?php if ( function_exists( 'ct_widget_tabs_comments') ) ct_widget_tabs_comments($number); ?>
                </ul>
                <?php } elseif ( $order == "tags" && !$tags == "on") { ?>
                  <div id="tab-tags" class="list">
                    <div class="pad10">
                      <?php wp_tag_cloud( 'smallest=12&largest=20' ); ?>
                    </div>
                  </div>
                  <?php } ?>

                  <?php if (!$pop == "on") { ?>
                  <ul id="tab-pop" class="list">
                      <?php if ( function_exists( 'ct_widget_tabs_popular') ) ct_widget_tabs_popular($number); ?>
                  </ul>
                  <?php } ?>
                  <?php if ($order <> "latest" && !$latest == "on") { ?>
                  <ul id="tab-latest" class="list">
                      <?php if ( function_exists( 'ct_widget_tabs_latest') ) ct_widget_tabs_latest($number); ?>
                  </ul>
                  <?php } ?>
                  <?php if ($order <> "comments" && !$comments == "on") { ?>
                  <ul id="tab-comm" class="list">
                      <?php if ( function_exists( 'ct_widget_tabs_comments') ) ct_widget_tabs_comments($number); ?>
                  </ul>
                  <?php } ?>
                  <?php if ($order <> "tags" && !$tags == "on") { ?>
                  <div id="tab-tags" class="list">
                    <div class="pad10">
                      <?php wp_tag_cloud( 'smallest=12&largest=20' ); ?>
                    </div>
                  </div>
                  <?php } ?>

              </div>

          <?php echo $after_widget; ?>
           <?php
     }

     function update($new_instance, $old_instance) {
         return $new_instance;
     }

     function form($instance) {
       
       $number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
       $order = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : '';
       $latest = isset( $instance['latest'] ) ? esc_attr( $instance['latest'] ) : '';
       $comments = isset( $instance['comments'] ) ? esc_attr( $instance['comments'] ) : '';
       $tags = isset( $instance['tags'] ) ? esc_attr( $instance['tags'] ) : '';

         ?>
         <p>
           <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts:', 'contempo' ); ?>
           <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
           </label>
         </p>
          <p>
              <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'First Visible Tab:', 'contempo' ); ?></label>
              <select name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>">
                  <option value="latest" <?php if($order == "latest"){ echo "selected='selected'";} ?>><?php _e( 'Latest', 'contempo' ); ?></option>
                  <option value="comments" <?php if($order == "comments"){ echo "selected='selected'";} ?>><?php _e( 'Comments', 'contempo' ); ?></option>
                  <option value="tags" <?php if($order == "tags"){ echo "selected='selected'";} ?>><?php _e( 'Tags', 'contempo' ); ?></option>
              </select>
          </p>
         <p><strong>Hide Tabs:</strong></p>
       <p>
           <input id="<?php echo $this->get_field_id( 'latest' ); ?>" name="<?php echo $this->get_field_name( 'latest' ); ?>" type="checkbox" <?php if($latest == 'on') echo 'checked="checked"'; ?>><?php _e( 'Latest', 'contempo' ); ?></input>
       </p>
       <p>
           <input id="<?php echo $this->get_field_id( 'comments' ); ?>" name="<?php echo $this->get_field_name( 'comments' ); ?>" type="checkbox" <?php if($comments == 'on') echo 'checked="checked"'; ?>><?php _e( 'Comments', 'contempo' ); ?></input>
       </p>
       <p>
           <input id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" type="checkbox" <?php if($tags == 'on') echo 'checked="checked"'; ?>><?php _e( 'Tags', 'contempo' ); ?></input>
         </p>
         <?php
     }

  }
}

/*-----------------------------------------------------------------------------------*/
/* ctTabs - Javascript */
/*-----------------------------------------------------------------------------------*/

// Add Javascript
add_action( 'wp_footer','ct_widget_tabs_js' );

if (!function_exists( 'ct_widget_tabs_js')) {
	function ct_widget_tabs_js(){
	?>
	<script>
	  jQuery(document).ready(function(){

	    var tag_cloud_class = '#tagcloud';
	    var tag_cloud_height = jQuery( '#tagcloud').height();
	    jQuery( '.tabs').each(function(){
	      jQuery(this).children( 'li').children( 'a:first').addClass( 'selected' );
	    });
	    jQuery( '.inside > *').hide();
	    jQuery( '.inside > *:first-child').show();

	    jQuery( '.tabs li a').click(function(evt){

	      var clicked_tab_ref = jQuery(this).attr( 'href' );

	      jQuery(this).parent().parent().children( 'li').children( 'a').removeClass( 'selected' )
	      jQuery(this).addClass( 'selected' );
	      jQuery(this).parent().parent().parent().children( '.inside').children( '*').hide();
	      jQuery(this).parent().parent().parent().children( '.inside').children( '*').hide();

	      jQuery( '.inside ' + clicked_tab_ref).fadeIn(500);

	       evt.preventDefault();
	    })
	  })
	</script>
	<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* ctTabs - Latest Posts */
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'ct_widget_tabs_latest')) {
  function ct_widget_tabs_latest( $posts = 5, $size = 45 ) {
    global $post;
    $latest = get_posts( 'ignore_sticky_posts=1&numberposts='. $posts .'&orderby=post_date&order=desc' );
    foreach($latest as $post) :
      setup_postdata($post);
  ?>
  <li>
      <div class="pad10">
          <?php if(has_post_thumbnail()) { ?>
            <div class="col span_3">
              <?php the_post_thumbnail('thumb'); ?>
            </div>
          <?php } ?>
          <div class="col <?php if(has_post_thumbnail()) { echo 'span_9'; } else { echo 'span_12'; } ?>">
              <h5 class="marB5"><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
              <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
          </div>
            <div class="clear"></div>
        </div>
  </li>
  <?php endforeach;
  }
}

/*-----------------------------------------------------------------------------------*/
/* ctTabs - Latest Comments */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'ct_widget_tabs_comments')) {
  function ct_widget_tabs_comments( $posts = 5, $size = 35 ) {
    global $wpdb;

    $comments = get_comments( array( 'number' => $posts, 'status' => 'approve' ) );
    if ( $comments ) {
      foreach ( (array) $comments as $comment) {
      $post = get_post( $comment->comment_post_ID );
      ?>
        <li class="recentcomments">
          <div class="pad10">
            <span class="right"><?php echo get_avatar( $comment, '40' ); ?></span>
            <h5><a href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php echo wp_filter_nohtml_kses($comment->comment_author); ?> <?php _e( 'on', 'contempo' ); ?> <?php echo $post->post_title; ?>"><?php echo wp_filter_nohtml_kses($comment->comment_author); ?>: <?php echo stripslashes(substr( wp_filter_nohtml_kses( $comment->comment_content ), 0, 50 )); ?>&hellip;</a></h5>
          </div>
        </li>
      <?php
      }
    }
  }
}

/**
 * Testimonials
 *
 * @package WP Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_Testimonials')) {
	class ct_Testimonials extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Display your testimonials.' );
		   parent::__construct(false, __('CT Testimonials', 'contempo'),$widget_ops);      
	   }

	   function widget($args, $instance) {  
		extract( $args );
		$title = $instance['title'];
		$number = $instance['number'];
		?>
			<?php echo $before_widget; ?>
	        <ul class="right">
	            <li><a class="prev test" href="#"><i class="fa fa-chevron-left"></i></a></li>
	            <li><a class="next test" href="#"><i class="fa fa-chevron-right"></i></a></li>
	        </ul>
			<?php if ($title) { echo $before_title . $title . $after_title; }
			echo '<div class="clear"></div>';
			echo '<ul class="testimonials">';
			global $post;
			$args = array(
				'post_type' => 'testimonial',
				'posts_per_page' => $number,
			);
			$query = new WP_Query($args);
	            
	        if ( have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
	        
	            <li>
	                <p class="marB10"><?php the_content(); ?>
	                <h6 class="marB0"><em><?php the_title(); ?></em></h6>
	            </li>

	        <?php endwhile; endif; wp_reset_query(); ?>
			
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
			
			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
			<p>
	            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number:','contempo'); ?></label>
	            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
	                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
	                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
	                <?php } ?>
	            </select>
	        </p>
			<?php
		}
	} 
}

/**
 * Listing Book Tour
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ListingBookShowing')) {
	class ct_ListingBookShowing extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Display a week calendar with time from/to for users to book a tour/showing of a listing.' );
			parent::__construct(false, __('CT Listing Book Showing', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) {  
			extract( $args );
		?>
			<?php echo $before_widget; ?>

				<script type="text/javascript">

					(function ($){
						"use strict";	
						var rep_month = new Array();
						var weekend= '', vacancy = '';
						var reinitOwl=true;
						var awaty_month = ("0" + (new Date().getMonth()+1)).slice(-2);
						var awaty_day = ("0" + new Date().getDate()).slice(-2);
						var awaty_year =  new Date().getFullYear();

						var number_of_days = 100;
						
						// Ready function to create slider uppond to options that user entered
						$.fn.calendar = function( options ) {		
						
						var defaults = $.extend({ 
							// These are the defaults.
							startDate: 'today',
							endDate: "",
							minDaysPerSlide: 5,
							weekend:"",	
						}, options );
						
						// start date value
						var startDate= defaults.startDate == 'today' ? awaty_month +'/'+ awaty_day +'/'+ awaty_year : defaults.startDate ;
						
						// end date value
						var endDate= defaults.endDate == '' ? ("0" + parseInt(new Date(new Date(startDate).getTime() + (number_of_days * 24 * 60 * 60 * 1000)).getMonth()+1, 10)).slice(-2) +'/'+ ("0" + new Date(new Date(startDate).getTime() + (number_of_days * 24 * 60 * 60 * 1000)).getDate()).slice(-2) +'/'+ new Date(new Date(startDate).getTime() + (number_of_days * 24 * 60 * 60 * 1000)).getFullYear() : defaults.endDate;

						// difference between end date and start date
						var diffDays=new Date( new Date(endDate) - new Date(startDate) );
						diffDays++;
						diffDays=diffDays/1000/60/60/24;
				        console.log(diffDays);
						
						// minimum days per slider to show on screen
						var minDaysPerSlide= defaults.minDaysPerSlide;		
						
						// weekend days
						defaults.weekend != '' ? weekend = defaults.weekend.toLowerCase().split(',') : weekend=[];		
						
						// display index of weekend days
						var wkend=[];
						for(var x=0; x<weekend.length; x++){
							wkend[x]= ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"].indexOf(weekend[x]);
						}
						
						// execute this code just for the first time
						if(reinitOwl == true){
							
							// owl determination
							var o1 = $(".calendar-slider.owl-carousel");
				            
							o1.owlCarousel({
								animateOut: 'fadeOut',
								nav: false,
								startPosition: 1,
								autoplay: false,
								center: true,
								loop: false,
								nav: false,
								dots: false,
								dots:false,
								responsive:{
									0:{
										items:3,
									},
									530:{
										items:3,
									},
									768:{
										items:2,
									},
									1025:{
										items: 3,
									}
								}
							});
							jQuery('#scheduleNext').click(function() {
							    o1.trigger('next.owl.carousel');

							    var itemDate = jQuery('.owl-item.active.center').first().children('.schedule-date').data('date');
								jQuery('#selectedDate').val(itemDate);
							});
							jQuery('#schedulePrev').click(function() {
							    o1.trigger('prev.owl.carousel');

							    var itemDate = jQuery('.owl-item.active.center').first().children('.schedule-date').data('date');
								jQuery('#selectedDate').val(itemDate);
							});
						}		
						
						// loop to append items to array
						var day=0;
						var tw_flag=false;
						for(var x=1; x<=Math.ceil(diffDays/minDaysPerSlide) ; x++){
							for(var x2=1; x2<=minDaysPerSlide; x2++){
								if(day <= diffDays){					
									var num_of_days = 1000 * 60 * 60 * 24 * day;
				            		num_of_days = new Date(new Date(startDate).getTime() + num_of_days);					

									$('.calendar-slider.owl-carousel').owlCarousel().trigger('add.owl.carousel',[jQuery('<a href="#!" class="schedule-date" data-date="'+["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][(num_of_days).getDay()]+', '+("0" + (num_of_days.getMonth()+1)).slice(-2)+'/'+("0" + num_of_days.getDate()).slice(-2)+'/'+num_of_days.getFullYear()+'"><div class="schedule-daytext">'+["SUN","MON","TUES","WED","THUR","FRI","SAT"][(num_of_days).getDay()]+'</div><div class="schedule-day">'+("0" + num_of_days.getDate()).slice(-2)+'</div><div class="schedule-month">'+["JAN","FEB","MAR","APR","MAY","JUNE","JULY","AUG","SEPT","OCT","NOV","DEC"][(num_of_days).getMonth()]+'</div></a>')]).trigger('refresh.owl.carousel');
					
								}
								day++;
							}
						}

						$(".calendar-slider.owl-carousel").fadeIn(100);
						reinitOwl = false;
					}
					
					})(jQuery);

					jQuery(function(){
						// calling function
						jQuery( ".calendar-slider" ).calendar({
							minDaysPerSlide: 1,
							weekend:"Sunday"
						});	
					});

					jQuery(window).load(function() {
						// Set Date On Load
						var selectedDate = jQuery('.owl-item.active.center .schedule-date').data('date');
						jQuery('#selectedDate').val(selectedDate);
					});

					jQuery(document).ready(function() {
						jQuery("#book-showing").validationEngine({
							ajaxSubmit: true,
							ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-book-listing-showing.php",
							ajaxSubmitMessage: "<?php _e('Thanks for booking a showing, we\'ll get back to confirm with you shortly.', 'contempo'); ?>",
							success :  false,
							failure : function() {}
						});
					});
				</script>

				<h4 class="marB20"><?php _e('Request a Showing', 'contempo'); ?></h4>

				<div class="schedule-calendar">
					<div id="schedulePrev"><i class="fa fa-angle-left"></i></div>
					<div class="calendar-slider owl-carousel">
					</div>
					<div id="scheduleNext"><i class="fa fa-angle-right"></i></div>
				</div>

				<form id="book-showing" class="formular" method="post">
					<p><em><?php _e('Select Your Time and Day', 'contempo'); ?></em></p>

					<div class="col span_5 first">
						<select name="showing_start">
							<option value="9:00 am">9:00 am</option>
							<option value="9:30 am">9:30 am</option>
							<option value="10:00 am">10:00 am</option>
							<option value="10:30 am">10:30 am</option>
							<option value="11:00 am">11:00 am</option>
							<option value="11:30 am">11:30 am</option>
							<option value="12:00 pm">12:00 pm</option>
							<option value="12:30 pm">12:30 pm</option>
							<option value="1:00 pm">1:00 pm</option>
							<option value="1:30 pm">1:30 pm</option>
							<option value="2:00 pm">2:00 pm</option>
							<option value="2:30 pm">2:30 pm</option>
							<option value="3:00 pm">3:00 pm</option>
							<option value="3:30 pm">3:30 pm</option>
							<option value="4:00 pm">4:00 pm</option>
							<option value="4:30 pm">4:30 pm</option>
							<option value="5:00 pm">5:00 pm</option>
							<option value="5:30 pm">5:30 pm</option>
							<option value="6:00 pm">6:00 pm</option>
						</select>
					</div>

					<div class="col span_2 muted">
						<?php _e('to', 'contempo'); ?>
					</div>

					<div class="col span_5">
						<select name="showing_end">
							<option value="10:00 am">10:00 am</option>
							<option value="10:30 am">10:30 am</option>
							<option value="11:00 am">11:00 am</option>
							<option value="11:30 am">11:30 am</option>
							<option value="12:00 pm">12:00 pm</option>
							<option value="12:30 pm">12:30 pm</option>
							<option value="1:00 pm">1:00 pm</option>
							<option value="1:30 pm">1:30 pm</option>
							<option value="2:00 pm">2:00 pm</option>
							<option value="2:30 pm">2:30 pm</option>
							<option value="3:00 pm">3:00 pm</option>
							<option value="3:30 pm">3:30 pm</option>
							<option value="4:00 pm">4:00 pm</option>
							<option value="4:30 pm">4:30 pm</option>
							<option value="5:00 pm">5:00 pm</option>
							<option value="5:30 pm">5:30 pm</option>
							<option value="6:00 pm">6:00 pm</option>
							<option value="6:30 pm">6:30 pm</option>
							<option value="7:00 pm">7:00 pm</option>
						</select>
					</div>

					<?php 
						$current_user = wp_get_current_user();
					?>

					<input type="hidden" id="selectedDate" name="selectedDate" value="" />
					<input type="hidden" id="name" name="name" value="<?php echo esc_html($current_user->user_firstname); ?> <?php echo esc_html($current_user->user_lastname); ?>" />
					<input type="hidden" id="email" name="email" value="<?php echo esc_html($current_user->user_email); ?>" />
					<input type="hidden" id="ctphone" name="ctphone" value="<?php echo esc_html($current_user->mobile); ?>" />
					<input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php the_author_meta('user_email'); ?>" />
					<input type="hidden" id="ctsubject" name="ctsubject" value="<?php _e('Showing Request for ', 'contempo'); ?> <?php ct_listing_title(); ?>" />
					<input type="hidden" id="ctproperty" name="ctproperty" value="<?php ct_listing_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
					<input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

					<div class="col span_12 first">
						<?php if(!is_user_logged_in()) { ?>
							<a class="btn login-register" href="#"><?php _e('Schedule Tour', 'contempo'); ?></a>
						<?php } else { ?>
							<input type="submit" name="Submit" value="<?php esc_html_e('Schedule Tour', 'contempo'); ?>" id="submit" class="btn" /> 
						<?php } ?>
					</div>

				</form>
			
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
			?>
			<p>
			   <?php _e('No options required for this widget.', 'contempo'); ?>
			</p>
			<?php
		}
	} 
}


/**
 * CT Social
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!class_exists('ct_Social')) {
	class ct_Social extends WP_Widget {

		function __construct() {
		   $widget_ops = array('description' => 'Use this widget to display your social profiles.' );
		   parent::__construct(false, __('CT Social', 'contempo'),$widget_ops);      
		}
		
		function widget($args, $instance) {  
		
			extract( $args );
			global $ct_options;
			
			$title = $instance['title'];
			$dribbble = $instance['dribbble'];
			$email = $instance['email'];
			$facebook = $instance['facebook'];
			$flickr = $instance['flickr'];
			$foursquare = $instance['foursquare'];
			$github = $instance['github'];
			$instagram = $instance['instagram'];
			$linkedin = $instance['linkedin'];
			$medium = $instance['medium'];
			$pinterest = $instance['pinterest'];
			$skype = $instance['skype'];
			$twitter = $instance['twitter'];
			$youtube = $instance['youtube'];
			$links = $instance['links'];
		
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; } ?>
	        <ul>
				<?php if($dribbble) { ?>
	                <li class="dribbble"><a href="<?php echo esc_url($dribbble); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-dribbble"></i></a></li>
	            <?php } ?>
	            <?php if($facebook) { ?>
	                <li class="facebook"><a href="<?php echo esc_url($facebook); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-facebook"></i></a></li>
	            <?php } ?>
	            <?php if($flickr) { ?>
	                <li class="flickr"><a href="<?php echo esc_url($flickr); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-flickr"></i></a></li>
	            <?php } ?>
	            <?php if($foursquare) { ?>
	                <li class="foursquare"><a href="<?php echo esc_url($foursquare); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-foursquare"></i></a></li>
	            <?php } ?>
	            <?php if($github) { ?>
	                <li class="github"><a href="<?php echo esc_url($github); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-github"></i></a></li>
	            <?php } ?>
	            <?php if($instagram) { ?>
	                <li class="instagram"><a href="<?php echo esc_url($instagram); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-instagram"></i></a></li>
	            <?php } ?>
	            <?php if($linkedin) { ?>
	                <li class="linkedin"><a href="<?php echo esc_url($linkedin); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-linkedin"></i></a></li>
	            <?php } ?>
	            <?php if($medium) { ?>
	                <li class="medium"><a href="<?php echo esc_url($medium); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-medium"></i></a></li>
	            <?php } ?>
	            <?php if($pinterest) { ?>
	                <li class="pinterest"><a href="<?php echo esc_url($pinterest); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-pinterest"></i></a></li>
	            <?php } ?>
	            <?php if($skype) { ?>
	                <li class="skype"><a href="<?php echo esc_url($skype); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-skype"></i></a></li>
	            <?php } ?>
	            <?php if($twitter) { ?>
	                <li class="twitter"><a href="<?php echo esc_url($twitter); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-twitter"></i></a></li>
	            <?php } ?>
	            <?php if($youtube) { ?>
	                <li class="youtube"><a href="<?php echo esc_url($youtube); ?>" target="<?php echo esc_html($links); ?>"><i class="fa fa-youtube"></i></a></li>
	            <?php } ?>
	             <?php if($email) { ?>
	                <li class="email"><a href="mailto:<?php echo esc_html($email); ?>"><i class="fa fa-envelope"></i></a></li>
	            <?php } ?>
	        </ul>	
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
		   
				$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
				$dribbble = isset( $instance['dribbble'] ) ? esc_attr( $instance['dribbble'] ) : '';
				$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
				$facebook = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
				$flickr = isset( $instance['flickr'] ) ? esc_attr( $instance['flickr'] ) : '';
				$foursquare = isset( $instance['foursquare'] ) ? esc_attr( $instance['foursquare'] ) : '';
				$github = isset( $instance['github'] ) ? esc_attr( $instance['github'] ) : '';
				$instagram = isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : '';
				$linkedin = isset( $instance['linkedin'] ) ? esc_attr( $instance['linkedin'] ) : '';
				$medium = isset( $instance['medium'] ) ? esc_attr( $instance['medium'] ) : '';
				$pinterest = isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : '';
				$skype = isset( $instance['skype'] ) ? esc_attr( $instance['skype'] ) : '';
				$twitter = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
				$youtube = isset( $instance['youtube'] ) ? esc_attr( $instance['youtube'] ) : '';
				$links = isset( $instance['links'] ) ? esc_attr( $instance['links'] ) : '';
				$size = isset( $instance['size'] ) ? esc_attr( $instance['size'] ) : '';
			
			?>
	        <p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php esc_html_e('Dribbble:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('dribbble'); ?>"  value="<?php echo esc_html($dribbble); ?>" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('email'); ?>"><?php esc_html_e('Email:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('email'); ?>"  value="<?php echo esc_html($email); ?>" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php esc_html_e('Facebook:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo esc_html($facebook); ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('flickr'); ?>"><?php esc_html_e('Flickr:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('flickr'); ?>"  value="<?php echo esc_html($flickr); ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php esc_html_e('Foursquare:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>"  value="<?php echo esc_html($foursquare); ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('github'); ?>"><?php esc_html_e('GitHub:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('github'); ?>"  value="<?php echo esc_html($github); ?>" class="widefat" id="<?php echo $this->get_field_id('github'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php esc_html_e('Instagram:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>"  value="<?php echo esc_html($instagram); ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php esc_html_e('LinkedIn:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>"  value="<?php echo esc_html($linkedin); ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('medium'); ?>"><?php esc_html_e('Medium:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('medium'); ?>"  value="<?php echo esc_html($medium); ?>" class="widefat" id="<?php echo $this->get_field_id('medium'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php esc_html_e('Pinterest:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>"  value="<?php echo esc_html($pinterest); ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('skype'); ?>"><?php esc_html_e('Skype:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('skype'); ?>"  value="<?php echo esc_html($skype); ?>" class="widefat" id="<?php echo $this->get_field_id('skype'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php esc_html_e('Twitter:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo esc_html($twitter); ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
			</p>
	        <p>
			   <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php esc_html_e('YouTube:','contempo'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>"  value="<?php echo esc_html($youtube); ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
			</p>
	        <p>
				<label for="<?php echo $this->get_field_id('links'); ?>"><?php esc_html_e('Links:', 'contempo'); ?></label> 
				<select id="<?php echo $this->get_field_id('links'); ?>" name="<?php echo $this->get_field_name('links'); ?>">
					<option value="_self"<?php if($links == '_self') echo ' selected="selected"'; ?>>Same Window</option>
					<option value="_blank"<?php if($links == '_blank') echo ' selected="selected"'; ?>>New Window</option>
				</select>
			</p>
			<?php
		}
	} 
}

?>