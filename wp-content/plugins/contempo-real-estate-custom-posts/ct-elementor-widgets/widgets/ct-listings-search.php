<?php
namespace CT_Elementor_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * CT Three Item Grid
 *
 * Elementor widget for listings minimal grid style.
 *
 * @since 1.0.0
 */
class CT_Listings_Search extends Widget_Base {

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
		return 'ct-listings-search';
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
		return __( 'CT Listings Search', 'contempo' );
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
		return 'eicon-search';
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
			'details',
			[
				'label' => __( 'Search Field Controls', 'contempo' ),
			]
		);

		$this->add_control(
			'important_note',
			[
				'label' => __( '', 'contempo' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'The search fields can be controlled in:</strong><br />Real Estate 7 Options > Advanced Search > Elementor Search Module', 'contempo' ),
			]
		);

		$this->add_control(
			'display_type',
			[
				'label' => __( 'Display Type', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'multiple' => __( 'Multiple Fields', 'contempo' ),
					'single' => __( 'Single "Keyword Style" Field', 'contempo' ),
				],
				'default' => 'multiple',
				'description' => __( 'Choose whether you\'d like to show multiple fields controlled via the Real Estate 7 Options area, or a single large field for Street, City, State, Zip or Keyword.', 'contempo'),
			]
		);

		$this->add_control(
			'display_size',
			[
				'label' => __( 'Display Size', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default-size' => __( 'Default', 'contempo' ),
					'large-size' => __( 'Large', 'contempo' ),
				],
				'default' => 'default-size',
				'description' => __( 'Choose the size you\'d like for the fields.', 'contempo'),
			]
		);

		$this->add_control(
			'suggested_results',
			[
				'label' => __( 'Suggested Results Display', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'on' => __( 'On', 'contempo' ),
					'off' => __( 'Off', 'contempo' ),
				],
				'default' => 'on',
				'description' => __( 'Choose whether or not you\'d like to show the ajax suggested results for the keyword field.', 'contempo'),
			]
		);

		$this->add_control(
			'search_button_style',
			[
				'label' => __( 'Search Button Style', 'contempo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'text' => __( 'Text', 'contempo' ),
					'icon' => __( 'Icon', 'contempo' ),
				],
				'default' => 'text',
				'description' => __( 'Choose whether you\'d like to use a text or icon style for the search button.', 'contempo'),
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

		global $ct_options;

		$ct_elementor_adv_search_fields = isset( $ct_options['ct_elementor_adv_search_fields']['enabled'] ) ? $ct_options['ct_elementor_adv_search_fields']['enabled'] : '';
		$ct_currency = isset( $ct_options['ct_currency'] ) ? $ct_options['ct_currency'] : '';
		$ct_sq = isset( $ct_options['ct_sq'] ) ? $ct_options['ct_sq'] : '';
		$ct_acres = isset( $ct_options['ct_acres'] ) ? $ct_options['ct_acres'] : '';
		$ct_bed_beds_or_bedrooms = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? esc_html( $ct_options['ct_bed_beds_or_bedrooms'] ) : '';
		$ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? esc_html( $ct_options['ct_bath_baths_or_bathrooms'] ) : '';

		/* Get Current Search Values for Inputs */

		$ct_beds_plus = isset( $_GET['ct_beds_plus']) ? $_GET['ct_beds_plus'] : '';
		$ct_baths_plus = isset( $_GET['ct_baths_plus']) ? $_GET['ct_baths_plus'] : '';

		$ct_price_from = isset( $_GET['ct_price_from']) ? $_GET['ct_price_from'] : '';
		$ct_price_to = isset( $_GET['ct_price_to']) ? $_GET['ct_price_to'] : '';

		$ct_price_from = str_replace($ct_currency, '', $ct_price_from);
		$ct_price_to = str_replace($ct_currency, '', $ct_price_to);

		$ct_sqft_from = isset( $_GET['ct_sqft_from']) ? $_GET['ct_sqft_from'] : '';
		$ct_sqft_from = str_replace($ct_sq, '', $ct_sqft_from);
		$ct_sqft_to = isset( $_GET['ct_sqft_to']) ? $_GET['ct_sqft_to'] : '';
		$ct_sqft_to = str_replace($ct_sq, '', $ct_sqft_to);

		$ct_lotsize_from = isset( $_GET['ct_lotsize_from']) ? $_GET['ct_lotsize_from'] : '';
		$ct_lotsize_from = str_replace($ct_acres, '', $ct_lotsize_from);
		$ct_lotsize_to = isset( $_GET['ct_lotsize_to']) ? $_GET['ct_lotsize_to'] : '';
		$ct_lotsize_to = str_replace($ct_acres, '', $ct_lotsize_to);

		$ct_community = isset( $_GET['ct_community']) ? $_GET['ct_community'] : '';

		$ct_mls = isset( $_GET['ct_mls']) ? $_GET['ct_mls'] : '';
		$ct_rental_guests = isset( $_GET['ct_rental_guests']) ? $_GET['ct_rental_guests'] : '';

		?>

		<style>
			.elementor-widget-ct-listings-search #advanced_search { background: none; border-radius: 0;}
				.elementor-widget-ct-listings-search #advanced_search #keyword-wrap svg { position: absolute; top: 12px; left: 15px;}
					.elementor-widget-ct-listings-search #advanced_search #keyword-wrap #ct_keyword { padding-left: 50px;}
						.elementor-widget-ct-listings-search .large-size #ct_keyword { padding-left: 60px !important;}
						.elementor-widget-ct-listings-search #advanced_search.search-icon-btn #keyword-wrap #ct_keyword { padding-left: 18px;}
				.elementor-widget-ct-listings-search #advanced_search button svg { position: relative; top: 5px;}
				.elementor-widget-ct-listings-search #advanced_search.header-search #submit { width: 100%; padding-right: 0; padding-left: 0; text-align: center;}
					.elementor-widget-ct-listings-search .large-size button { height: 62px; line-height: 62px;}
						.elementor-widget-ct-listings-search .large-size button svg {}
							.elementor-widget-ct-listings-search .large-size.search-icon-btn button { width: 62px; padding: 0;}
			@media only screen and (max-width: 767px) {
				.elementor-widget-ct-listings-search #advanced_search .col { width: 100% !important; margin-left: 0 !important;}
				.elementor-widget-ct-listings-search #advanced_search.header-search #submit { display: block !important;}
			}
			@media only screen and (max-width: 767px) {
				.elementor-widget-ct-listings-search #advanced_search.header-search.single-field-search-style .col.span_1 { width: 6.5% !important;}
			}
		</style>

		<form id="advanced_search" class="header-search <?php if(!empty($settings['display_type'])) { echo $settings['display_type'] . '-field-search-style'; } ?> <?php if(!empty($settings['display_size'])) { echo $settings['display_size']; } ?> <?php if($settings['search_button_style'] == 'icon') { echo 'search-icon-btn'; } else { echo 'search-text-btn'; } ?>" name="search-listings" action="<?php echo home_url(); ?>">
		<?php
			if($settings['display_type'] == 'single') { ?>

				<div id="suggested-search" class="col <?php if($settings['search_button_style'] == 'icon') { echo 'span_11'; } else { echo 'span_10'; } ?> first">
	            	<div id="keyword-wrap">	
	            		<?php if($settings['search_button_style'] != 'icon') { ?>
	            			<?php if(function_exists('ct_search_svg_muted')) {
	            				ct_search_svg_muted();
	            			} ?>
	            		<?php } ?>			
		                <label for="ct_keyword"><?php _e('Keyword', 'contempo'); ?></label>
		                <input type="text" id="ct_keyword" class="number hero_keyword_search <?php if($settings['search_button_style'] == 'icon') { echo 'hero_keyword_search_no_icon'; } ?>" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Enter a Street, City, State, Zip or keyword', 'contempo'); ?>" autocomplete="off" />
	                </div>
	                <?php if($settings['suggested_results'] != 'off') { ?>
						<div class="listing-search" style="display: none"><i class="fa fa-spinner fa-spin fa-fw"></i><?php _e('Searching...', 'contempo'); ?></div>
						<div id="hero-suggestion-box" style="display: none;"></div>
					<?php } ?>
	            </div>

	            <?php if($settings['suggested_results'] != 'off') { ?>
		            <script>
					jQuery(".hero_keyword_search").keyup(function($){
						var keyword_value = jQuery(this).val();
						
						var data = {
							action: 'street_keyword_search',
							keyword_value: keyword_value
						};

						jQuery(".listing-search").show();

						jQuery.ajax({
							type: "POST",
							url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",		
							data: data,	
							success: function(data){
								console.log(data);
								jQuery(".listing-search").hide();
								jQuery("#hero-suggestion-box").show();
								jQuery("#hero-suggestion-box").html(data);
							}
						}); 
					});

					jQuery(document).on("click",'.listing_media',function(){	
						var list_title = jQuery(this).attr('att_id');
						jQuery(".hero_keyword_search").val(list_title);
						jQuery("#hero-suggestion-box").hide();	
					});
					</script>
				<?php } ?>

				<input type="hidden" name="search-listings" value="true" />

	            <div class="col <?php if($settings['search_button_style'] == 'icon') { echo 'span_1 search-icon-btn'; } else { echo 'span_2'; } ?>">
	            	<?php if($settings['search_button_style'] == 'icon') { ?>
	            		<?php if(function_exists('ct_search_svg')) { ?>
            				<button class="left"><?php ct_search_svg(); ?></button>
            			<?php } else { ?>
            				<input id="submit" class="btn left" style="font-family: 'Font Awesome 5 Free' !important; font-weight: 900 !important;" type="submit" value="&#xf002;" />
            			<?php } ?>
	            	<?php } else { ?>
						<input id="submit" class="btn left" type="submit" value="<?php _e('Search', 'contempo'); ?>" />	           
					<?php } ?>
			    </div>

			<?php } else {

	    		if ($ct_elementor_adv_search_fields) {			    
				    foreach ($ct_elementor_adv_search_fields as $field=>$value) {			    
				        switch($field) {						
						// Type            
				        case 'header_type' : ?>
				            <div id="property_type" class="col span_2">
				                <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
				                <?php ct_search_form_select('property_type'); ?>
				            </div>
				        <?php
						break;
						
						// City
						case 'header_city' : ?>
						<div id="city_code" class="col span_2">
							<label for="ct_city"><?php _e('City', 'contempo'); ?></label>
							<?php ct_search_form_select('city'); ?>
							<div class="my_old_city" style=" display: none;"></div>
							
						</div>
				        <?php
						break;
						
				        // State            
				        case 'header_state' : ?>
				            <div id="state_code" class="col span_2">
								<?php ct_search_form_select('state'); ?>
								<div class="my_old_state" style=" display: none;"></div>
								
				            </div>
				        <?php
						break;

						// Zipcode            
				        case 'header_zipcode' : ?>
				            <div id="zip_code" class="col span_2 ">
								<?php ct_search_form_select('zipcode'); ?>
								<div class="my_old_data" style=" display: none;"></div>
				            </div>
				        <?php
						break;

				        // Country            
				        case 'header_country' : ?>
				            <div id="country_code" class="col span_2">
				                <label for="ct_country"><?php _e('Country', 'contempo'); ?></label>
				                <?php ct_search_form_select('country'); ?>
								<div class="my_old_country" style=" display: none;"></div>
				            </div>
				        <?php
				        break;

				        // County            
				        case 'header_county' : ?>
				            <div class="col span_2">
				                <label for="ct_county"><?php _e('County', 'contempo'); ?></label>
				                <?php ct_search_form_select('county'); ?>
				            </div>
				        <?php
				        break;

				        // Community            
				        case 'header_type' : ?>
				            <div class="col span_2">
				                <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
				                <?php ct_search_form_select('community'); ?>
				            </div>
				        <?php
				        break;
						
						// Beds            
				        case 'header_beds' : ?>
				            <div class="col span_2">
				                <label for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
								<?php ct_search_form_select('beds'); ?>
				            </div>
				        <?php
						break;
						
						// Baths            
				        case 'header_baths' : ?>
				            <div class="col span_2">
				                <label for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
								<?php ct_search_form_select('baths'); ?>
				            </div>
				        <?php
						break;

						// Beds            
				        case 'header_beds_plus' : ?>
				            <div class="col span_2">
				                <label for="ct_beds_plus"><?php _e('Beds +', 'contempo'); ?></label>
								<select id="ct_beds_plus" name="ct_beds_plus">
									<option value="0">
										<?php if($ct_bed_beds_or_bedrooms == 'rooms') {
							    			_e('All Rooms', 'contempo');
							    		} elseif($ct_bed_beds_or_bedrooms == 'bedrooms') {
							    			_e('All Bedrooms', 'contempo');
							    		} elseif($ct_bed_beds_or_bedrooms == 'beds') {
							    			_e('All Beds', 'contempo');
								    	} else {
								    		_e('All Bed', 'contempo');
								    	} ?>
								    	<option value="1" <?php if($ct_beds_plus == 1) { echo 'selected'; } ?>>1+</option>
								    	<option value="2" <?php if($ct_beds_plus == 2) { echo 'selected'; } ?>>2+</option>
								    	<option value="3" <?php if($ct_beds_plus == 3) { echo 'selected'; } ?>>3+</option>
								    	<option value="4" <?php if($ct_beds_plus == 4) { echo 'selected'; } ?>>4+</option>
								    	<option value="5" <?php if($ct_beds_plus == 5) { echo 'selected'; } ?>>5+</option>
									</option>
								</select>
				            </div>
				        <?php
						break;
						
						// Baths            
				        case 'header_baths_plus' : ?>
				            <div class="col span_2">
				                <label for="ct_baths_plus"><?php _e('Baths +', 'contempo'); ?></label>
								<select id="ct_baths_plus" name="ct_baths_plus">
									<option value="0">
										<?php if($ct_bath_baths_or_bathrooms == 'bathrooms') {
							    			_e('All Bathrooms', 'contempo');
							    		} elseif($ct_bath_baths_or_bathrooms == 'baths') {
							    			_e('All Baths', 'contempo');
							    		} else {
								    		_e('All Bath', 'contempo');
								    	} ?>
								    	<option value="1" <?php if($ct_baths_plus == 1) { echo 'selected'; } ?>>1+</option>
								    	<option value="2" <?php if($ct_baths_plus == 2) { echo 'selected'; } ?>>2+</option>
								    	<option value="3" <?php if($ct_baths_plus == 3) { echo 'selected'; } ?>>3+</option>
								    	<option value="4" <?php if($ct_baths_plus == 4) { echo 'selected'; } ?>>4+</option>
								    	<option value="5" <?php if($ct_baths_plus == 5) { echo 'selected'; } ?>>5+</option>
									</option>
								</select>
				            </div>
				        <?php
						break;
						
						// Status            
				        case 'header_status' : ?>
				            <div class="col span_2">
				                <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
								<?php ct_search_form_select('ct_status'); ?>
				            </div>
				        <?php
						break;

				        // Community          
				        case 'header_community' : ?>
				            <div class="col span_2">
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
				        case 'header_price_from' : ?>
				            <div class="col span_2">
				                <label for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
				                <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" <?php if($ct_price_from != '') { echo 'value="'; ct_currency(); echo esc_html($ct_price_from) . '"'; } ?> />
				            </div>
				        <?php
						break;
						
						// Price To            
				        case 'header_price_to' : ?>
				            <div class="col span_2">
				                <label for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
				                <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" <?php if($ct_price_to != '') { echo 'value="'; ct_currency(); echo esc_html($ct_price_to) . '"'; } ?> />
				            </div>
				        <?php
						break;

						// Price Slider            
				        case 'header_price_from_to_slider' : ?>
				            <div id="price-from-to-slider" class="col span_3">
					            <div class="col span_12 first">
					            	<span class="slider-label"><?php _e('Price range:', 'contempo'); ?></span>
					            	<span class="min-range">100,000</span>
					            	<span class="slider-label"><?php _e('to', 'contempo'); ?></span>
								    <span class="max-range">5,000,000</span>
					            </div>
				            	<div class="slider-range-wrap col span_12 first">
								    <div id="slider-range"></div>
								</div>
				                <input type="hidden" id="ct_price_from" class="number" name="ct_price_from" size="8" <?php if($ct_price_from != '') { echo 'value="' . esc_html($ct_price_from) . '"'; } ?> />
				                <input type="hidden" id="ct_price_to" class="number" name="ct_price_to" size="8" <?php if($ct_price_to != '') { echo 'value="' . esc_html($ct_price_to) . '"'; } ?> />
				            </div>
				        <?php
						break;

				        // Sq Ft From            
				        case 'header_sqft_from' : ?>
				            <div class="col span_3">
				                <label for="ct_sqft_from"><?php ct_sqftsqm(); ?> <?php _e('From', 'contempo'); ?></label>
				                <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> - <?php ct_sqftsqm(); ?>" <?php if($ct_sqft_from != '') { echo 'value="' . $ct_sqft_from; echo ' ' . $ct_sq . '"'; } ?> />
				            </div>
				        <?php
				        break;
				        
				        // Sq Ft To            
				        case 'header_sqft_to' : ?>
				            <div class="col span_2">
				                <label for="ct_sqft_to"><?php ct_sqftsqm(); ?> <?php _e('To', 'contempo'); ?></label>
				                <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> - <?php ct_sqftsqm(); ?>" <?php if($ct_sqft_to != '') { echo 'value="' . $ct_sqft_to; echo ' ' . $ct_sq . '"'; } ?> />
				            </div>
				        <?php
				        break;

				        // Sq Ft Slider            
				        case 'header_sqft_from_to_slider' : ?>
				            <div id="size-from-to-slider" class="col span_3">
				            	<div class="col span_12 first">
					            	<span class="slider-label"><?php _e('Size range:', 'contempo'); ?></span>
					            	<span class="min-range">100</span>
					            	<span class="slider-label"><?php _e('to', 'contempo'); ?></span>
								    <span class="max-range">10,000</span>
					            </div>
				            	<div class="slider-range-wrap col span_12 first">
								    <div id="slider-range-two"></div>
								</div>
				                <input type="hidden" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" <?php if($ct_sqft_from != '') { echo 'value="' . $ct_sqft_from . '"'; } ?> />
				                <input type="hidden" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" <?php if($ct_sqft_to != '') { echo 'value="' . $ct_sqft_to . '"'; } ?> />
				            </div>
				        <?php
				        break;

				        // Lot Size From            
				        case 'header_lotsize_from' : ?>
				            <div class="col span_2">
				                <label for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
				                <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> - <?php ct_acres(); ?>" <?php if($ct_lotsize_from != '') { echo 'value="' . $ct_lotsize_from; echo ' ' . $ct_acres . '"'; } ?> />
				            </div>
				        <?php
				        break;
				        
				        // Lot Size To            
				        case 'header_lotsize_to' : ?>
				            <div class="col span_2">
				                <label for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
				                <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> - <?php ct_acres(); ?>" <?php if($ct_lotsize_to != '') { echo 'value="' . $ct_lotsize_to; echo ' ' . $ct_acres . '"'; } ?> />
				            </div>
				        <?php
				        break;

				        // Lot Size Slider            
				        case 'header_lotsize_from_to_slider' : ?>
				            <div id="lotsize-from-to-slider" class="col span_3">
				            	<div class="col span_12 first">
					            	<?php _e('Lot Size', 'contempo'); ?>
					            	<span class="slider-label"><?php _e('Lot size range:', 'contempo'); ?></span>
					            	<span class="min-range">0</span>
					            	<span class="slider-label"><?php _e('to', 'contempo'); ?></span>
								    <span class="max-range">100</span>
					            </div>
				            	<div class="slider-range-wrap col span_12 first">
								    <div id="slider-range-three"></div>
								</div>
				                <input type="hidden" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" <?php if($ct_lotsize_from != '') { echo 'value="' . $ct_lotsize_from . '"'; } ?> />
				                <input type="hidden" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" <?php if($ct_lotsize_to != '') { echo 'value="' . $ct_lotsize_to . '"'; } ?> />
				            </div>
				        <?php
				        break;
						
						// MLS            
				        case 'header_mls' : ?>
				            <div class="col span_2">
				                <?php if(class_exists('IDX')) { ?>
				                    <label for="ct_mls"><?php _e('MLS ID', 'contempo'); ?></label>
				                    <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('MLS ID', 'contempo'); ?>" <?php if($ct_mls != '') { echo 'value="' . $ct_mls . '"'; } ?> />
				                <?php } else { ?>
				                    <label for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
				                    <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" <?php if($ct_mls != '') { echo 'value="' . $ct_mls . '"'; } ?> />
				                <?php } ?>
				            </div>
				        <?php
						break;

				        // Number of Guests            
				        case 'header_numguests' : ?>
				            <div class="col span_2">
				                <label for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
				                <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" <?php if($ct_rental_guests != '') { echo 'value="' . $ct_rental_guests . '"'; } ?> />
				            </div>
				        <?php
				        break;

				        // Keyword           
				        case 'header_keyword' : ?>


				            <div id="suggested-search" class="col span_3">
				            	<div id="keyword-wrap">					
				            		<?php if($settings['search_button_style'] != 'icon') { ?>
					            		<i class="fas fa-search"></i>	
				            		<?php } ?>
					                <label for="ct_keyword"><?php _e('Keyword', 'contempo'); ?></label>
					                <input type="text" id="ct_keyword" class="number hero_keyword_search <?php if($settings['search_button_style'] == 'icon') { echo 'hero_keyword_search_no_icon'; } ?>" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Street, City, State, Zip or keyword', 'contempo'); ?>" autocomplete="off" />
				                </div>
								<div class="listing-search" style="display: none"><i class="fas fa-spinner fa-spin fa-fw"></i><?php _e('Searching...', 'contempo'); ?></div>
								<div id="hero-suggestion-box" style="display: none;"></div>
				            </div>

				            <script>
							jQuery(".hero_keyword_search").keyup(function($){
								var keyword_value = jQuery(this).val();
								
								var data = {
									action: 'street_keyword_search',
									keyword_value: keyword_value
								};

								jQuery(".listing-search").show();

								jQuery.ajax({
									type: "POST",
									url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",		
									data: data,	
									success: function(data){
										console.log(data);
										jQuery(".listing-search").hide();
										jQuery("#hero-suggestion-box").show();
										jQuery("#hero-suggestion-box").html(data);
									}
								}); 
							});

							jQuery(document).on("click",'.listing_media',function(){	
								var list_title = jQuery(this).attr('att_id');
								jQuery(".hero_keyword_search").val(list_title);
								jQuery("#hero-suggestion-box").hide();	
							});
							</script>
				        <?php
				        break;
				        }
				    
				    } ?>

				    <input type="hidden" name="search-listings" value="true" />

		            <div class="col <?php if($settings['search_button_style'] == 'icon') { echo 'span_1'; } else { echo 'span_2'; } ?> <?php if($settings['search_button_style'] == 'icon') { echo 'search-icon-btn'; } ?>">
						<?php if($settings['search_button_style'] == 'icon') { ?>
		            		<input id="submit" class="btn left search-icon-btn" style="font-family: 'Font Awesome 5 Free' !important; font-weight: 900 !important;" type="submit" value="&#xf002;" />	
		            	<?php } else { ?>
							<input id="submit" class="btn left" type="submit" value="<?php _e('Search', 'contempo'); ?>" />	           
						<?php } ?>          
				    </div>

				<?php } ?>

			<?php } ?>

		         <div class="clear"></div>

			<input type="hidden" name="lat" id="search-latitude">
			<input type="hidden" name="lng" id="search-longitude">
        </form>
	        <div class="clear"></div>

	<?php }

}
