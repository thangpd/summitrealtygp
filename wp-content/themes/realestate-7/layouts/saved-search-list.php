<?php
/**
 * Saved Search List
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_search_data, $ct_options;

$ct_currency = isset( $ct_options['ct_currency'] ) ? esc_attr( $ct_options['ct_currency'] ) : '';
$ct_currency_placement = isset( $ct_options['ct_currency_placement'] ) ? esc_attr( $ct_options['ct_currency_placement'] ) : '';

$format = 'Y-m-d H:i:s';$date = DateTime::createFromFormat($format, $ct_search_data->time);
$time = $date->format('Y-m-d');
$ct_search_args = $ct_search_data->query;
$ct_search_url = $ct_search_data->url;
$ct_search_url_parts = parse_url($ct_search_url);

if($ct_search_url != 'email-alerts') {
	parse_str($ct_search_url_parts['query'], $ct_search_url_query);
}

$ct_search_args_decoded = unserialize( base64_decode( $ct_search_args ) );

$ct_beds = isset($ct_search_args_decoded['beds']) ? $ct_search_args_decoded['beds'] : '';
$ct_baths = isset($ct_search_args_decoded['baths']) ? $ct_search_args_decoded['baths'] : '';
$ct_property_type = isset($ct_search_args_decoded['property_type']) ? ct_get_property_type_name($ct_search_args_decoded['property_type']) : '';
$ct_city = isset($ct_search_args_decoded['city']) ? ct_get_city_name($ct_search_args_decoded['city']) : '';
$ct_state = isset($ct_search_args_decoded['state']) ? ct_get_state_name($ct_search_args_decoded['state']) : '';
$ct_status = isset($ct_search_args_decoded['status']) ? ct_get_status_name($ct_search_args_decoded['status']) : '';
$ct_zipcode = isset($ct_search_args_decoded['zip']) ? $ct_search_args_decoded['zip'] : '';
$ct_price_from = isset($ct_search_args_decoded['pricefrom']) ? $ct_search_args_decoded['pricefrom'] : '';
$ct_price_to = isset($ct_search_args_decoded['priceto']) ? $ct_search_args_decoded['priceto'] : '';
$ct_year_from = isset($ct_search_args_decoded['yearfrom']) ? $ct_search_args_decoded['yearfrom'] : '';
$ct_year_to = isset($ct_search_args_decoded['yearto']) ? $ct_search_args_decoded['yearto'] : '';

$ct_search_url_beds = isset($ct_search_url_query['ct_beds']) ? $ct_search_url_query['ct_beds'] : '';
$ct_search_url_beds_plus = isset($ct_search_url_query['ct_beds_plus']) ? $ct_search_url_query['ct_beds_plus'] : '';
$ct_search_url_baths = isset($ct_search_url_query['ct_baths']) ? $ct_search_url_query['ct_baths'] : '';
$ct_search_url_baths_plus = isset($ct_search_url_query['ct_baths_plus']) ? $ct_search_url_query['ct_baths_plus'] : '';
$ct_search_url_property_type = isset($ct_search_url_query['ct_property_type']) ? ct_get_property_type_name($ct_search_url_query['ct_property_type']) : '';
$ct_search_url_city = isset($ct_search_url_query['ct_city']) ? ct_get_city_name($ct_search_url_query['ct_city']) : '';
$ct_search_url_state = isset($ct_search_url_query['ct_state']) ? ct_get_state_name($ct_search_url_query['ct_state']) : '';
$ct_search_url_status = isset($ct_search_url_query['ct_ct_status']) ? ct_get_status_name($ct_search_url_query['ct_ct_status']) : '';
$ct_search_url_zipcode = isset($ct_search_url_query['ct_zipcode']) ? $ct_search_url_query['ct_zipcode'] : '';
$ct_search_url_price_from = isset($ct_search_url_query['ct_price_from']) ? $ct_search_url_query['ct_price_from'] : '';
$ct_search_url_price_to = isset($ct_search_url_query['ct_price_to']) ? $ct_search_url_query['ct_price_to'] : '';
$ct_search_url_year_from = isset($ct_search_url_query['ct_year_from']) ? $ct_search_url_query['ct_year_from'] : '';
$ct_search_url_year_to = isset($ct_search_url_query['ct_year_to']) ? $ct_search_url_query['ct_year_to'] : '';

$ct_search_url_price_from = str_replace(',', '', $ct_search_url_price_from);
$ct_search_url_price_to = str_replace(',', '', $ct_search_url_price_to);
$ct_search_url_price_from = str_replace($ct_currency, '', $ct_search_url_price_from);
$ct_search_url_price_to = str_replace($ct_currency, '', $ct_search_url_price_to);

?>

<li class="saved-search-block">                              
	<div class="col span_7 first">                                    
		<p class="saved-alert-query">
			<?php if($ct_search_url != 'email-alerts') { ?>
				<a href="<?php echo esc_url($ct_search_url); ?>">
			<?php } else { ?>
				<a href="<?php echo home_url(); ?>/?saved_search=<?php if($ct_beds != '') { echo '&ct_beds=' . $ct_search_args_decoded['beds']; } ?><?php if($ct_baths != '') { echo '&ct_baths=' . $ct_search_args_decoded['baths']; } ?><?php if($ct_property_type != '') { echo '&ct_property_type=' . $ct_search_args_decoded['property_type']; } ?><?php if($ct_city != '') { echo '&ct_city=' . $ct_search_args_decoded['city']; } ?><?php if($ct_state != '') { echo '&ct_state=' . $ct_search_args_decoded['state']; } ?><?php if($ct_status != '') { echo '&ct_ct_state=' . $ct_search_args_decoded['status']; } ?><?php if($ct_zipcode != '') { echo '&ct_zipcode=' . $ct_search_args_decoded['zip']; } ?><?php if($ct_price_from != '') { echo '&ct_price_from=' . $ct_search_args_decoded['pricefrom']; } ?><?php if($ct_price_to != '') { echo '&ct_price_to=' . $ct_search_args_decoded['priceto']; } ?>&search-listings=true">
			<?php } ?>
				<?php
				if('' != $ct_status){ echo esc_html($ct_status) . ', ';}
				if('' != $ct_search_url_status){ echo ucwords($ct_search_url_status) . ', ';}
				if('' != $ct_property_type){ echo esc_html($ct_property_type) . ', ';}

				if('' != $ct_beds){ echo esc_html($ct_beds) . ' beds, ';}
				if('' != $ct_baths){ echo esc_html($ct_baths) . ' baths, ';}

				if('' != $ct_search_url_beds_plus){ echo esc_html($ct_search_url_beds_plus) . '+ beds, ';}
				if('' != $ct_search_url_baths_plus){ echo esc_html($ct_search_url_baths_plus) . '+ baths, ';}

				if('' != $ct_year_from){ echo esc_html($ct_year_from) . ', ';}
				if('' != $ct_year_to){ echo esc_html($ct_year_to) . ', ';}

				if('' != $ct_search_url_year_from){ echo esc_html($ct_search_url_year_from) . ', ';}
				if('' != $ct_search_url_year_to){ echo esc_html($ct_search_url_year_to) . ', ';}
				
				if($ct_currency_placement == 'after') {
					if('' != $ct_price_from){ echo number_format_i18n($ct_price_from, 0); ct_currency(); echo ', ';}
					if('' != $ct_price_to){ ct_currency(); echo number_format_i18n($ct_price_to, 0); ct_currency(); echo ', ';}
				} else {
					if('' != $ct_price_from){ ct_currency(); echo number_format_i18n($ct_price_from, 0) . ', ';}
					if('' != $ct_price_to){ ct_currency(); echo number_format_i18n($ct_price_to, 0) . ', ';}
				}
				
				if($ct_currency_placement == 'after') {
					if('' != $ct_search_url_price_from){ echo number_format_i18n($ct_search_url_price_from, 0); ct_currency(); echo ', ';}
					if('' != $ct_search_url_price_to){ ct_currency(); echo number_format_i18n($ct_search_url_price_to, 0); ct_currency(); echo ', ';}
				} else {
					if('' != $ct_search_url_price_from){ ct_currency(); echo number_format_i18n($ct_search_url_price_from, 0) . ', ';}
					if('' != $ct_search_url_price_to){ ct_currency(); echo number_format_i18n($ct_search_url_price_to, 0) . ', ';}
				}
				
				if('' != $ct_city){ echo esc_html($ct_city) . ', ';}
				if('' != $ct_state){ echo esc_html($ct_state) . ' ';}
				if('' != $ct_zipcode){ echo esc_html($ct_zipcode) . ' ';}

				?>
			</a>
		</p>
    </div>                                                                    
	<div class="col span_2">
		<p><?php echo esc_html($time); ?></p>                                
	</div>
	<div class="col span_2">                                    
		<select class="esetting">
			<option value="<?php _e('on', 'contempo'); ?>"><?php _e('On', 'contempo'); ?></option>
			<option value="<?php _e('off', 'contempo'); ?>"><?php _e('Off', 'contempo'); ?></option>
		</select>
	</div>                                
	<div class="col span_1 delete">
		<a class="remove-search btn" href="#" data-propertyid='<?php echo intval($ct_search_data->id); ?>'><i class="fa fa-trash-o"></i></a>
	</div>
</li>  
	<div class="clear"></div>