<?php
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
        $ct_currency = isset( $ct_options['ct_currency'] ) ? $ct_options['ct_currency'] : '';
        $ct_sq = isset( $ct_options['ct_sq'] ) ? $ct_options['ct_sq'] : '';
        $ct_acres = isset( $ct_options['ct_acres'] ) ? $ct_options['ct_acres'] : '';
        $ct_bed_beds_or_bedrooms = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? esc_html( $ct_options['ct_bed_beds_or_bedrooms'] ) : '';
        $ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? esc_html( $ct_options['ct_bath_baths_or_bathrooms'] ) : '';

        $ct_adv_search_price_slider_min_value = isset( $ct_options['ct_adv_search_price_slider_min_value'] ) ? $ct_options['ct_adv_search_price_slider_min_value'] : '';
        $ct_adv_search_price_slider_max_value = isset( $ct_options['ct_adv_search_price_slider_max_value'] ) ? $ct_options['ct_adv_search_price_slider_max_value'] : '';

        $ct_adv_search_size_slider_min_value = isset( $ct_options['ct_adv_search_size_slider_min_value'] ) ? $ct_options['ct_adv_search_size_slider_min_value'] : '';
        $ct_adv_search_size_slider_max_value = isset( $ct_options['ct_adv_search_size_slider_max_value'] ) ? $ct_options['ct_adv_search_size_slider_max_value'] : '';

        $ct_adv_search_lot_size_slider_min_value = isset( $ct_options['ct_adv_search_lot_size_slider_min_value'] ) ? $ct_options['ct_adv_search_lot_size_slider_min_value'] : '';
        $ct_adv_search_lot_size_slider_max_value = isset( $ct_options['ct_adv_search_lot_size_slider_max_value'] ) ? $ct_options['ct_adv_search_lot_size_slider_max_value'] : '';

        $ct_years = array('2020','2019','2018','2017','2016','2015','2010','2005','2000','1990','1980','1970','1960','1950','1940','1930','1920','1910','1900');

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

        $ct_year_from = isset( $_GET['ct_year_from']) ? $_GET['ct_year_from'] : '';
        $ct_year_to = isset( $_GET['ct_year_to']) ? $_GET['ct_year_to'] : '';

        $ct_community = isset( $_GET['ct_community']) ? $_GET['ct_community'] : '';

        $ct_mls = isset( $_GET['ct_mls']) ? $_GET['ct_mls'] : '';
        $ct_rental_guests = isset( $_GET['ct_rental_guests']) ? $_GET['ct_rental_guests'] : '';
    	
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
                        case 'type' :
                            if(!in_array('Type (multi)', $ct_home_adv_search_fields)) { ?>
                                <div id="property_type" class="col span_12 first">
                                    <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
                                    <?php ct_search_form_select('property_type'); ?>
                                </div>
                            <?php }
                        break;

                        // Type Multi        
                        case 'type_multi' :
                            if(!in_array('Type', $ct_home_adv_search_fields)) { ?>
                                <div id="property_type" class="col span_12 first">
                                    <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
                                    <?php ct_search_form_checkboxes_toggles_property_type('property_type'); ?>
                                </div>
                            <?php }
                        break;
                        
                        // City
                        case 'city' : ?>
                        <div id="city_code" class="col span_12 first">
                            <label for="ct_city"><?php _e('City', 'contempo'); ?></label>
                            <?php ct_search_form_select('city'); ?>
                        </div>
                        <?php
                        break;
                        
                        // State            
                        case 'state' : ?>
                            <div id="state_code" class="col span_12 first">
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
                            <div id="zip_code" class="col span_12 first">
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
                            <div class="col span_12 first">
                                <label for="ct_country"><?php _e('Country', 'contempo'); ?></label>
                                <?php ct_search_form_select('country'); ?>
                            </div>
                        <?php
                        break;

                        // Country            
                        case 'county' : ?>
                            <div id="county" class="col span_12 first">
                                <label for="ct_county"><?php _e('County', 'contempo'); ?></label>
                                <?php ct_search_form_select('county'); ?>
                            </div>
                        <?php
                        break;

                        // Community            
                        case 'community' : ?>
                            <div id="ct_community" class="col span_12 first">
                                <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
                                <?php ct_search_form_select('community'); ?>
                            </div>
                        <?php
                        break;
                        
                        // Beds            
                        case 'beds' : ?>
                            <div class="col span_12 first">
                                <label for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
                                <?php ct_search_form_select('beds'); ?>
                            </div>
                        <?php
                        break;
                        
                        // Baths            
                        case 'baths' : ?>
                            <div class="col span_12 first">
                                <label for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
                                <?php ct_search_form_select('baths'); ?>
                            </div>
                        <?php
                        break;

                        // Beds Plus            
                        case 'beds_plus' : ?>
                            <div class="col span_12 first">
                                <label for="ct_beds_plus"><?php _e('Beds +', 'contempo'); ?></label>
                                <select id="ct_beds_plus" name="ct_beds_plus">
                                    <option value="">
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
                        
                        // Baths Plus           
                        case 'baths_plus' : ?>
                            <div class="col span_12 first">
                                <label for="ct_baths_plus"><?php _e('Baths +', 'contempo'); ?></label>
                                <select id="ct_baths_plus" name="ct_baths_plus">
                                    <option value="">
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
                        case 'status' : ?>
                            <div id="status" class="col span_12 first">
                                <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
                                <?php ct_search_form_select('ct_status'); ?>
                            </div>
                        <?php
                        break;

                        // Status Multi        
                        case 'status_multi' :
                            if(!in_array('Status', $ct_home_adv_search_fields)) { ?>
                                <div id="status" class="col span_12 first">
                                    <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
                                    <?php ct_search_form_checkboxes_toggles_status('ct_status'); ?>
                                </div>
                            <?php }
                        break;
                        
                        // Additional Features            
                        case 'additional_features' : ?>
                            <div class="col span_12 first">
                                <label for="ct_additional_features"><?php _e('Additional Features', 'contempo'); ?></label>
                                <?php ct_search_form_select('additional_features'); ?>
                            </div>
                        <?php
                        break;

                        // Community          
                        case 'community' : ?>
                            <div class="col span_12 first">
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
                            <div class="col span_12 first">
                                <label for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" />
                            </div>
                        <?php
                        break;
                        
                        // Price To            
                        case 'price_to' : ?>
                            <div class="col span_12 first">
                                <label for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" />
                            </div>
                        <?php
                        break;

                        /* Price Slider            
                        case 'price_from_to_slider' : ?>
                            <div id="price-from-to-slider" class="col span_12 first">
                                <div class="col span_12 first">
                                    <span class="slider-label"><?php _e('Price range:', 'contempo'); ?></span>
                                    <span class="min-range"><?php if(!empty($ct_adv_search_price_slider_min_value)) { echo $ct_adv_search_price_slider_min_value; } else { echo '100,000'; } ?></span>
                                    <span class="slider-label"><?php _e('to', 'contempo'); ?></span>
                                    <span class="max-range"><?php if(!empty($ct_adv_search_price_slider_max_value)) { echo $ct_adv_search_price_slider_max_value; } else { echo '5,000,000'; } ?></span>
                                </div>
                                <div class="slider-range-wrap col span_11 first">
                                    <div id="slider-range"></div>
                                </div>
                                <input type="hidden" id="ct_price_from" class="number" name="ct_price_from" size="8" <?php if($ct_price_from != '') { echo 'value="' . esc_html($ct_price_from) . '"'; } ?> />
                                <input type="hidden" id="ct_price_to" class="number" name="ct_price_to" size="8" <?php if($ct_price_to != '') { echo 'value="' . esc_html($ct_price_to) . '"'; } ?> />
                            </div>
                        <?php
                        break;
                        */

                        // Sq Ft From            
                        case 'sqft_from' : ?>
                            <div class="col span_12 first">
                                <label for="ct_sqft_from"><?php ct_sqftsqm(); ?> <?php _e('From', 'contempo'); ?></label>
                                <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                            </div>
                        <?php
                        break;
                        
                        // Sq Ft To            
                        case 'sqft_to' : ?>
                            <div class="col span_12 first">
                                <label for="ct_sqft_to"><?php ct_sqftsqm(); ?> <?php _e('To', 'contempo'); ?></label>
                                <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                            </div>
                        <?php
                        break;

                        /* Sq Ft Slider            
                        case 'sqft_from_to_slider' : ?>
                            <div id="size-from-to-slider" class="col span_12 first">
                                <div class="col span_12 first">
                                    <span class="slider-label"><?php _e('Size range:', 'contempo'); ?></span>
                                    <span class="min-range"><?php if(!empty($ct_adv_search_size_slider_min_value)) { echo $ct_adv_search_size_slider_min_value; } else { echo '100'; } ?></span>
                                    <span class="slider-label"><?php _e('to', 'contempo'); ?></span>
                                    <span class="max-range"><?php if(!empty($ct_adv_search_size_slider_max_value)) { echo $ct_adv_search_size_slider_max_value; } else { echo '10,000'; } ?></span>
                                </div>
                                <div class="slider-range-wrap col span_11 first">
                                    <div id="slider-range-two"></div>
                                </div>
                                <input type="hidden" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" <?php if($ct_sqft_from != '') { echo 'value="' . $ct_sqft_from . '"'; } ?> />
                                <input type="hidden" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" <?php if($ct_sqft_to != '') { echo 'value="' . $ct_sqft_to . '"'; } ?> />
                            </div>
                        <?php
                        break;
                        */

                        // Lot Size From            
                        case 'lotsize_from' : ?>
                            <div class="col span_12 first">
                                <label for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
                                <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                            </div>
                        <?php
                        break;
                        
                        // Lot Size To            
                        case 'lotsize_to' : ?>
                            <div class="col span_12 first">
                                <label for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
                                <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                            </div>
                        <?php
                        break;

                        /* Lot Size Slider            
                        case 'lotsize_from_to_slider' : ?>
                            <div id="lotsize-from-to-slider" class="col span_12 first">
                                <div class="col span_12 first">
                                    <span class="slider-label"><?php _e('Lot size range:', 'contempo'); ?></span>
                                    <span class="min-range"><?php if(!empty($ct_adv_search_lot_size_slider_min_value)) { echo $ct_adv_search_lot_size_slider_min_value; } else { echo '0'; } ?></span>
                                    <span class="slider-label"><?php _e('to', 'contempo'); ?></span>
                                    <span class="max-range"><?php if(!empty($ct_adv_search_lot_size_slider_max_value)) { echo $ct_adv_search_lot_size_slider_max_value; } else { echo '100'; } ?></span>
                                </div>
                                <div class="slider-range-wrap col span_11 first">
                                    <div id="slider-range-three"></div>
                                </div>
                                <input type="hidden" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" <?php if($ct_lotsize_from != '') { echo 'value="' . $ct_lotsize_from . '"'; } ?> />
                                <input type="hidden" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" <?php if($ct_lotsize_to != '') { echo 'value="' . $ct_lotsize_to . '"'; } ?> />
                            </div>
                        <?php
                        break;
                        */
                        
                        // MLS            
                        case 'mls' : ?>
                            <div class="col span_12 first">
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
                            <div class="col span_12 first">
                                <label for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
                                <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" />
                            </div>
                        <?php
                        break;

                        }
                    
                    } endif; ?>
                    
                        <div class="clear"></div>
                    
                    <input type="hidden" name="search-listings" value="true" />

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
    		   <label class="muted" for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
    		   <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
    		</p>
    		<?php
    	}
    } 
}

register_widget('ct_ListingsSearch');
?>