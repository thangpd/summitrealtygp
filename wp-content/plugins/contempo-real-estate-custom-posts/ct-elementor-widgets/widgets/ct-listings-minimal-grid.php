<?php
namespace CT_Elementor_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * CT Listings Minimal Grid
 *
 * Elementor widget for listings minimal grid style.
 *
 * @since 1.0.0
 */
class CT_Listings_Minimal_Grid extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ct-listings-minimal-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'CT Listings Minimal Grid', 'contempo' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ct-real-estate-7' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Query', 'contempo' ),
			]
		);

		if(class_exists('IDX')) {
			$this->add_control(
				'idx',
				[
					'label' => __( 'Display IDX Listings?', 'contempo' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'no' => __( 'No', 'contempo' ),
						'yes' => __( 'Yes', 'contempo' ),
					],
					'default' => 'no',
				]
			);
		}

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1' => __( '1', 'contempo' ),
					'2' => __( '2', 'contempo' ),
					'3' => __( '3', 'contempo' ),
					'4' => __( '4', 'contempo' ),
					'6' => __( '6', 'contempo' ),
					'7' => __( '7', 'contempo' ),
					'8' => __( '8', 'contempo' ),
				],
				'default' => '2',
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'ASC' => __( 'Ascending', 'contempo' ),
					'DESC' => __( 'Descending', 'contempo' ),
				],
				'default' => 'ASC',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date' => __( 'Date', 'contempo' ),
					'price' => __( 'Price', 'contempo' ),
					'rand' => __( 'Random', 'contempo' ),
				],
				'default' => 'date',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_listing_parameters',
			[
				'label' => __( 'Listing Parameters', 'contempo' ),
			]
		);

		if(class_exists('IDX')) {
			$this->add_control(
				'idx_agent',
				[
					'label' => __( 'Agent Name', 'contempo' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Mary Sanders', 'contempo'),
					'description' => __( 'Show only a specific agents MLS listings, e.g. Mary Sanders, Bill Johnson, Ryan Serhant.', 'contempo'),
				]
			);
		}

		if(class_exists('IDX')) {
			$this->add_control(
				'mls_number',
				[
					'label' => __( 'MLS Number', 'contempo' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( '123456', 'contempo'),
					'description' => __( 'Show only a single specific listing by MLS Number.', 'contempo'),
				]
			);
		}

		$this->add_control(
			'type',
			[
				'label' => __( 'Type', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'single-family-home', 'contempo'),
				'description' => __( 'Enter the type, e.g. single-family-home, condo, commercial.', 'contempo'),
			]
		);

		$this->add_control(
			'price_min',
			[
				'label' => __( 'Price Min', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0',
				'placeholder' => __( 'No Minimum', 'contempo'),
				'description' => __( 'Enter the price without currency or separators, e.g. 250000', 'contempo'),
			]
		);

		$this->add_control(
			'price_max',
			[
				'label' => __( 'Price Max', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'No Maximum', 'contempo'),
				'description' => __( 'Enter the price without currency or separators, e.g. 950000', 'contempo'),
			]
		);

		$this->add_control(
			'beds',
			[
				'label' => __( 'Beds', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '3', 'contempo'),
				//'description' => __( 'Enter the beds, e.g. 2, 3, 4.', 'contempo'),
			]
		);

		$this->add_control(
			'baths',
			[
				'label' => __( 'Baths', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '2', 'contempo'),
				//'description' => __( 'Enter the baths, e.g. 2, 3, 4.', 'contempo'),
			]
		);

		$this->add_control(
			'status',
			[
				'label' => __( 'Status', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for-sale', 'contempo'),
				'description' => __( 'Enter the status, e.g. for-sale, for-rent, open-house.', 'contempo'),
			]
		);

		$this->add_control(
			'exclude_sold',
			[
				'label' => __( 'Exclude Sold?', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => __( 'No', 'contempo' ),
					'sold' => __( 'Yes', 'contempo' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'city',
			[
				'label' => __( 'City', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'san-diego', 'contempo'),
				'description' => __( 'Enter the city, e.g. san-diego, los-angeles, new-york.', 'contempo'),
			]
		);

		$this->add_control(
			'state',
			[
				'label' => __( 'State', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'ca', 'contempo'),
				'description' => __( 'Enter the state, e.g. ca, tx, ny.', 'contempo'),
			]
		);

		$this->add_control(
			'zipcode',
			[
				'label' => __( 'Zip or Postcode', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '92101', 'contempo'),
				'description' => __( 'Enter the zip or postcode, e.g. 92101, 92065, 94027.', 'contempo'),
			]
		);

		$this->add_control(
			'county',
			[
				'label' => __( 'County', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '', 'contempo'),
				'description' => __( 'Enter the county, e.g. alpine-county, imperial-county, napa-county.', 'contempo'),
			]
		);

		$this->add_control(
			'country',
			[
				'label' => __( 'Country', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '', 'contempo'),
				'description' => __( 'Enter the country, e.g. usa, england, greece.', 'contempo'),
			]
		);

		$this->add_control(
			'community',
			[
				'label' => __( 'Community', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '', 'contempo'),
				'description' => __( 'Enter the community, e.g. the-grand-estates, broadstone-apartments.', 'contempo'),
			]
		);

		$this->add_control(
			'additional_features',
			[
				'label' => __( 'Additional Features', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '', 'contempo'),
				'description' => __( 'Enter the additional features, e.g. pool, gated, beach-frontage.', 'contempo'),
			]
		);

		$this->add_control(
			'brokerage_id',
			[
				'label' => __( 'Brokerage ID', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '', 'contempo'),
				'description' => __( 'Enter the ID of the Brokerage here, e.g. 36, you can get this in your Admin > Brokerages area.', 'contempo'),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Output Listings
		echo '<ul class="col span_12 row first">';

			global $post, $wp_query, $wpdb;
			global $ct_options;

			$ct_price_from = str_replace(',', '', $settings['price_min']);
			$ct_price_to = str_replace(',', '', $settings['price_max']);

			if($ct_price_from == '' || $ct_price_to == '') {
				$ct_price_from = '0';
				$ct_price_to = '200000000';
			}

			if(!class_exists('IDX')) {
				$settings['idx'] = '';
				$settings['mls_number'] = '';
			}

			if(!empty($settings['mls_number'])) {

				$args = array(
        			'post_type' => 'listings',
        			'orderby' => $settings['orderby'],
					'order' => $settings['order'],
					'meta_query' => array(
						array(
					        'key' => 'source',
					        'value' => 'idx-api',
					    	'type' => 'char',
							'compare' => '='
					    ),
						array(
							'key' => '_ct_mls',
							'value' => $settings['mls_number'],
							'type' => 'char',
							'compare' => '='
						),
					),
        			'posts_per_page' => 1
    			);

			} else {

				if($settings['orderby'] == 'price') {
					$ct_price = get_post_meta($post->ID, "_ct_price", true);
					if($settings['idx'] == 'yes') {
						$args = array(
		       				'ct_status' => $settings['status'],
				            'property_type' => $settings['type'],
		        			'beds' => $$settings['beds'],
				            'baths' => $settings['baths'],
		        			'city' => $settings['city'],
				            'state' => $settings['state'],
		        			'zipcode' => $settings['zipcode'],
		        			'country' => $settings['country'],
		        			'county' => $settings['county'],
		        			'community' => $settings['community'],
		        			'additional_features' => $settings['additional_features'],
		        			'post_type' => 'listings',
				            'orderby' => 'meta_value',
							'meta_key' => '_ct_price',
							'meta_type' => 'numeric',
							'meta_query' => array(
							    array(
							        'key' => 'source',
							        'value' => 'idx-api',
							    	'type' => 'char',
									'compare' => '='
							    ),
							    array(
							        'key' => '_ct_agent_name',
							        'value' => $settings['idx_agent'],
							    	'type' => 'char',
									'compare' => 'LIKE'
							    ),
							    array(
									'key' => '_ct_price',
									'value' => array( $ct_price_from, $ct_price_to ),
									'type' => 'NUMERIC',
									'compare' => 'BETWEEN'
								),
								array(
									'key' => '_ct_brokerage',
									'value' => $settings['brokerage_id'],
									'type' => 'NUMERIC',
									'compare' => 'LIKE'
								),
							),
							'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field'     => 'slug',
								    'terms'     => $settings['exclude_sold'],
						            'operator' => 'NOT IN'
						        )
						    ),
							'order' => $settings['order'],
				            'posts_per_page' => $settings['layout']
		    			);
					} else {
						$args = array(
		       				'ct_status' => $settings['status'],
				            'property_type' => $settings['type'],
		        			'beds' => $$settings['beds'],
				            'baths' => $settings['baths'],
		        			'city' => $settings['city'],
				            'state' => $settings['state'],
		        			'zipcode' => $settings['zipcode'],
		        			'country' => $settings['country'],
		        			'county' => $settings['county'],
		        			'community' => $settings['community'],
		        			'additional_features' => $settings['additional_features'],
		        			'post_type' => 'listings',
				            'orderby' => 'meta_value',
							'meta_key' => '_ct_price',
							'meta_type' => 'numeric',
							'meta_query' => array(
								array(
							        'key' => 'source',
							        'value' => 'idx-api',
							    	'compare' => 'NOT EXISTS'
							    ),
								array(
									'key' => '_ct_price',
									'value' => array( $ct_price_from, $ct_price_to ),
									'type' => 'NUMERIC',
									'compare' => 'BETWEEN'
								),
								array(
									'key' => '_ct_brokerage',
									'value' => $settings['brokerage_id'],
									'type' => 'NUMERIC',
									'compare' => 'LIKE'
								),
							),
							'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field'     => 'slug',
								    'terms'     => $settings['exclude_sold'],
						            'operator' => 'NOT IN'
						        )
						    ),
							'order' => $settings['order'],
				            'posts_per_page' => $settings['layout']
		    			);
					}
				} else {
					if($settings['idx'] == 'yes') {
		    			$args = array(
		        			'ct_status' => $settings['status'],
		        			'property_type' => $settings['type'],
		        			'beds' => $settings['beds'],
				            'baths' => $settings['baths'],
		        			'city' => $settings['city'],
				            'state' => $settings['state'],
		        			'zipcode' => $settings['zipcode'],
		        			'country' => $settings['country'],
		        			'county' => $settings['county'],
		        			'community' => $settings['community'],
		        			'additional_features' => $settings['additional_features'],
		        			'post_type' => 'listings',
		        			'orderby' => $settings['orderby'],
							'order' => $settings['order'],
							'meta_query' => array(
							    array(
							        'key' => 'source',
							        'value' => 'idx-api',
							    	'type' => 'char',
									'compare' => '='
							    ),
							    array(
							        'key' => '_ct_agent_name',
							        'value' => $settings['idx_agent'],
							    	'type' => 'char',
									'compare' => 'LIKE'
							    ),
							    array(
									'key' => '_ct_price',
									'value' => array( $ct_price_from, $ct_price_to ),
									'type' => 'NUMERIC',
									'compare' => 'BETWEEN'
								),
								array(
									'key' => '_ct_brokerage',
									'value' => $settings['brokerage_id'],
									'type' => 'NUMERIC',
									'compare' => 'LIKE'
								),
							),
							'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field'     => 'slug',
								    'terms'     => $settings['exclude_sold'],
						            'operator' => 'NOT IN'
						        )
						    ),
		        			'posts_per_page' => $settings['layout']
		    			);
					} else {
						$args = array(
		        			'ct_status' => $settings['status'],
		        			'property_type' => $settings['type'],
		        			'beds' => $settings['beds'],
				            'baths' => $settings['baths'],
		        			'city' => $settings['city'],
				            'state' => $settings['state'],
		        			'zipcode' => $settings['zipcode'],
		        			'country' => $settings['country'],
		        			'county' => $settings['county'],
		        			'community' => $settings['community'],
		        			'additional_features' => $settings['additional_features'],
		        			'post_type' => 'listings',
		        			'orderby' => $settings['orderby'],
							'order' => $settings['order'],
							'meta_query' => array(
								array(
							        'key' => 'source',
							        'value' => 'idx-api',
							    	'compare' => 'NOT EXISTS'
							    ),
								array(
									'key' => '_ct_price',
									'value' => array( $ct_price_from, $ct_price_to ),
									'type' => 'NUMERIC',
									'compare' => 'BETWEEN'
								),
								array(
									'key' => '_ct_brokerage',
									'value' => $settings['brokerage_id'],
									'type' => 'NUMERIC',
									'compare' => 'LIKE'
								),
							),
							'tax_query' => array(
						        array(
						            'taxonomy' => 'ct_status',
						            'field'     => 'slug',
								    'terms'     => $settings['exclude_sold'],
						            'operator' => 'NOT IN'
						        )
						    ),
		        			'posts_per_page' => $settings['layout']
		    			);
					}
				}
			}
			$wp_query = new \wp_query( $args );
	        
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

	        $beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
		    $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

		    $ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';
			$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
			$ct_listing_stats_on_off = isset( $ct_options['ct_listing_stats_on_off'] ) ? esc_attr( $ct_options['ct_listing_stats_on_off'] ) : '';
			$ct_bed_beds_or_bedrooms = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? esc_html( $ct_options['ct_bed_beds_or_bedrooms'] ) : '';
		    $ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? esc_html( $ct_options['ct_bath_baths_or_bathrooms'] ) : '';
			$ct_listings_lotsize_format = isset( $ct_options['ct_listings_lotsize_format'] ) ? esc_html( $ct_options['ct_listings_lotsize_format'] ) : '';
		    
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
	        
	        <?php if($settings['layout'] == '1') { ?>
	        	<li class="listing col span_12 minimal first <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
	        <?php } elseif($settings['layout'] == '2') { ?>
	        	<li class="listing col span_6 minimal <?php if($count == 0) { echo 'first'; } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
	    	<?php } elseif($settings['layout'] == '3') { ?>
	        	<li class="listing col <?php if($count == 0) { echo 'span_8 first'; } else { echo 'span_4'; } ?> minimal <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
	        <?php } elseif($settings['layout'] == '4') { ?>
	        	<li class="listing col span_6 minimal <?php if($count == 0 || $count == 2) { echo 'first'; } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
		    <?php } elseif ($settings['layout'] == '6') { ?>
	        	<li class="listing col <?php if($count == 0 || $count == 1) { echo 'span_6'; } else { echo 'span_3'; } ?> minimal <?php if($count == 0 || $count == 2) { echo 'first'; } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
	         <?php } elseif ($settings['layout'] == '7') { ?>
	        	<li class="listing col <?php if($count == 0 || $count == 1 || $count == 2) { echo 'span_4'; } else { echo 'span_3'; } ?> minimal <?php if($count == 0 || $count == 3) { echo 'first'; } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
	        <?php } elseif($settings['layout'] == '8') { ?>
	        	<li class="listing col span_3 minimal <?php if($count == 0 || $count == 4) { echo 'first'; } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
	        <?php } ?>

	            <figure>
	            	<?php
	           			if(has_term( 'featured', 'ct_status' ) ) {
							echo '<h6 class="snipe featured">';
								echo '<span>';
									echo __('Featured', 'contempo');
								echo '</span>';
							echo '</h6>';
						}
					?>
	                <?php
		                $status_tags = strip_tags( get_the_term_list( $wp_query->post->ID, 'ct_status', '', ' ', '' ) );
						if($status_tags != '') {
							echo '<h6 class="snipe status ';
									$status_terms = get_the_terms( $wp_query->post->ID, 'ct_status', array() );
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

								if(get_post_meta($post->ID, "source", true) != 'idx-api') { 
									echo '<li>';
										echo '<span class="listing-images-count" data-tooltip="' . $img_count . __(' Photos','contempo') . '">';
											echo '<i class="fa fa-image"></i>';
										echo '</span>';
									echo '</li>';
								}
								
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
		                	<?php do_action('before_elementor_listing_list_propinfo'); ?>
							<?php ct_propinfo(); ?>
							<?php do_action('after_elementor_listing_list_propinfo'); ?>
	                    </ul>
	                </div>
	            </div>
		
	        </li>
	        
	        <?php
			
			$count++;
			
			if($settings['layout'] == '6' && $count == '2') {
				echo '<div class="clear"></div>';
			}

			if($settings['layout'] == '2' && $count == '2') {
	        	echo '<div class="clear"></div>';
	        } elseif($settings['layout'] == '3' && $count == '3') {
	        	echo '<div class="clear"></div>';
	        } elseif($settings['layout'] == '4' && $count == '4') {
	        	echo '<div class="clear"></div>';
		    } elseif ($settings['layout'] == '6' && $count == '6') {
	        	echo '<div class="clear"></div>';
	        } elseif ($settings['layout'] == '7' && $count == '7') {
	        	echo '<div class="clear"></div>';
	        } elseif($settings['layout'] == '8' && $count == '4') {
	        	echo '<div class="clear"></div>';
	        }
			
			endwhile;

			else:
			
				echo '<div class="nomatches">';
					echo '<h4 class="marB5"><strong>' . __('No results for those listing parameters.','contempo') . '</strong></h4>';
					echo '<p class="marB0">' . __('Try different settings or refreshing/changing existing ones.', 'contempo') . '</p>';
				echo '</div>';

			endif;
			
			wp_reset_query();
			wp_reset_postdata();

		echo '</ul>';
		    echo '<div class="clear"></div>';

	}

}
