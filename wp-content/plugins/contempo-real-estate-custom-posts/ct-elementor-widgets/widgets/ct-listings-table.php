<?php
namespace CT_Elementor_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * CT Listings List
 *
 * Elementor widget for listings list style.
 *
 * @since 1.0.0
 */
class CT_Listings_Table extends Widget_Base {

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
		return 'ct-listings-table';
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
		return __( 'CT Listings Table', 'contempo' );
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
		return 'eicon-table';
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
			'number',
			[
				'label' => __( 'Number', 'contempo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '6', 'contempo'),
				'description' => __( 'Enter the number to show per page, if you\'d like to show all enter -1.', 'contempo'),
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
				'default' => '',
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

			global $post, $wp_query, $wpdb;
			global $ct_options;

			if(empty($settings['number'])) {
				$number = 3;
			} else {
				$number = $settings['number'];
			}

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
				            'posts_per_page' => $number
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
				            'posts_per_page' => $number
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
		        			'posts_per_page' => $number
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
		        			'posts_per_page' => $number
		    			);
					}
				}
			}
			$wp_query = new \wp_query( $args );
	        
	        $count = 0;

	        $ct_bed_beds_or_bedrooms = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? esc_html( $ct_options['ct_bed_beds_or_bedrooms'] ) : '';
		    $ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? esc_html( $ct_options['ct_bath_baths_or_bathrooms'] ) : '';

			// Output Listings
			echo '<table>';
				echo '<thead>';
					echo '<tr>';
						echo '<th>' . __('Address', 'contempo') . '</th>';
						echo '<th>' . __('Location', 'contempo') . '</th>';
						echo '<th>' . __('Price', 'contempo') . '</th>';
						if(has_term('commercial', 'property_type', $wp_query->post->ID)) { 
							// Nothing
						} else {
							echo '<th>';
								if($ct_bed_beds_or_bedrooms == 'rooms') {
					    			_e('Rooms', 'contempo');
					    		} elseif($ct_bed_beds_or_bedrooms == 'bedrooms') {
					    			_e('Bedrooms', 'contempo');
					    		} elseif($ct_bed_beds_or_bedrooms == 'beds') {
					    			_e('Beds', 'contempo');
						    	} else {
						    		_e('Bed', 'contempo');
						    	}
						    echo '</th>';
							echo '<th>';
								if($ct_bath_baths_or_bathrooms == 'bathrooms') {
					    			_e('Bathrooms', 'contempo');
					    		} elseif($ct_bath_baths_or_bathrooms == 'baths') {
					    			_e('Baths', 'contempo');
					    		} else {
						    		_e('Bath', 'contempo');
						    	}
							echo '</th>';
						}
						echo '<th>';
							if(function_exists('ct_sqftsqm')) { 
								ct_sqftsqm();
							}
						echo '</th>';
						echo '<th>' . __('Price Per Sq Ft', 'contempo') . '</th>';
					echo '</tr>';
				echo '</thead>';
			echo '<tbody>';

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

		    ?>

				<tr>
					<td>
						<a href="<?php the_permalink(); ?>"><?php if(function_exists('ct_listing_title')) { ct_listing_title(); } ?></a>
					</td>
					<td>
						<?php if(!empty($city)) { echo esc_html($city); } else { echo '-'; } ?>
					</td>
					<td>
						<?php if(function_exists('ct_listing_price')) { ct_listing_price(); } ?>
					</td>
					<?php if(has_term('commercial', 'property_type', $wp_query->post->ID)) {  ?>
						<?php // Nothing ?>
					<?php } else { ?>
						<td>
							<?php if(!empty($beds)) { echo esc_html($beds); } else { echo '-'; } ?>
						</td>
						<td>
							<?php if(!empty($beds)) { echo esc_html($baths); } else { echo '-'; } ?>
						</td>
					<?php } ?>
					<td>
						<?php if(get_post_meta($wp_query->post->ID, "_ct_sqft", true)) {
							$value = get_post_meta($wp_query->post->ID, "_ct_sqft", true);
							 if(is_numeric($value)) {
								 echo number_format_i18n($value, 0);
							 } else {
							 	echo esc_html($value);
							 }
						} ?>
					</td>
					<td>
						<?php
						$price_meta = get_post_meta($wp_query->post->ID, '_ct_price', true);
						$price_meta= preg_replace('/[\$,]/', '', $price_meta);
						$ct_sqft = get_post_meta(get_the_ID(), '_ct_sqft', true);

					    if(has_term('for-rent', 'ct_status') || has_term('rental', 'ct_status') || has_term('leased', 'ct_status') || has_term('lease', 'ct_status') || has_term('let', 'ct_status') || has_term('sold', 'ct_status')) {
					    	_e('N/A', 'contempo');
					    } elseif(!empty($price_meta) && !empty($ct_sqft)) {
						    if(function_exists('ct_listing_price_per_sqft')) { ct_listing_price_per_sqft(); }
						} ?>
					</td>
				</tr>

	        <?php 

		        $count++;
			
			endwhile;

			else:
			
				echo '<div class="nomatches">';
					echo '<h4 class="marB5"><strong>' . __('No results for those listing parameters.','contempo') . '</strong></h4>';
					echo '<p class="marB0">' . __('Try different settings or refreshing/changing existing ones.', 'contempo') . '</p>';
				echo '</div>';

			endif;

			wp_reset_query();
			wp_reset_postdata();
			
			echo '</tbody>';
		echo '</table>';
	
		    echo '<div class="clear"></div>';

	}

}
