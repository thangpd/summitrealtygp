<?php
/**
 * Single Listing Google Places
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_enable_yelp_nearby = isset( $ct_options['ct_enable_yelp_nearby'] ) ? esc_html( $ct_options['ct_enable_yelp_nearby'] ) : '';
$ct_google_maps_api_key = isset( $ct_options['ct_google_maps_api_key'] ) ? stripslashes( $ct_options['ct_google_maps_api_key'] ) : '';
$ct_latlng = get_post_meta(get_the_ID(), '_ct_latlng', true);

do_action('before_single_listing_google_places');
            
echo '<!-- Nearby -->';
if($ct_google_maps_api_key != '') {

    $ct_google_places_amenities = isset( $ct_options['ct_yelp_amenities']['enabled'] ) ? $ct_options['ct_yelp_amenities']['enabled'] : '';

    echo '<div class="listing-nearby" id="listing-nearby">';
        echo '<h4 class="border-bottom marB20">' . __('What\'s Nearby?', 'contempo') . '</h4>';
        
        $city = wp_get_post_terms(get_the_ID(), 'city');
        $city = $city[0];
        $city = $city->name;

        $state = wp_get_post_terms(get_the_ID(), 'state');
        $state = $state[0];
        $state = $state->name;

        $zip = wp_get_post_terms(get_the_ID(), 'zipcode');
        $zip = $zip[0];
        $zip = $zip->name;

        $street = get_the_title(get_the_ID());

        if(!empty($ct_latlng)) {

            $ct_listing_lat_long = preg_replace('/\s+/', '', $ct_latlng);

        } elseif($street && $city) {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($street.' '.$city.', '.$state.' '.$zip)."&sensor=false";
            $resp = wp_remote_get($url);
            if ( 200 == $resp['response']['code'] ) {
                $body = $resp['body'];
                $data = json_decode($body);
                if($data->status=="OK"){
                    $latitude = $data->results[0]->geometry->location->lat;
                    $longitude = $data->results[0]->geometry->location->lng;
                    $ct_listing_lat_long = $latitude.','.$longitude;
                }
            }
        }

        if ($ct_google_places_amenities) :

        foreach ($ct_google_places_amenities as $field=>$value) {
        
            switch($field) {
                
                // Restaurant            
                case 'restaurant' :

                    echo '<h5><i class="fa fa-cutlery"></i> ' . __('Restaurants', 'contempo') . '</h5>';

                    ct_google_places_nearby('restaurant', $ct_listing_lat_long);
                    
                break;

                // Coffee Shops            
                case 'coffee_shops' :

                    echo '<h5><i class="fa fa-coffee"></i> ' . __('Coffee Shops', 'contempo') . '</h5>';

                    ct_google_places_nearby('cafe', $ct_listing_lat_long);
                    
                break;

                // Stores           
                case 'grocery' :

                    echo '<h5><i class="fa fa-shopping-basket"></i> ' . __('Stores', 'contempo') . '</h5>';

                    ct_google_places_nearby('store', $ct_listing_lat_long);
                    
                break;

                // Schools           
                case 'schools' :

                    echo '<h5><i class="fa fa-mortar-board"></i> ' . __('Education', 'contempo') . '</h5>';

                    ct_google_places_nearby('school', $ct_listing_lat_long);
                    
                break;

                // Banks           
                case 'banks' :

                    echo '<h5><i class="fa fa-bank"></i> ' . __('Banks', 'contempo') . '</h5>';

                    ct_google_places_nearby('bank', $ct_listing_lat_long);
                    
                break;

                // Bars           
                case 'bars' :

                    echo '<h5><i class="fa fa-beer"></i> ' . __('Bars', 'contempo') . '</h5>';

                    ct_google_places_nearby('bar', $ct_listing_lat_long);
                    
                break;

                // Hospitals           
                case 'hospitals' :

                    echo '<h5><i class="fa fa-hospital-o"></i> ' . __('Hospitals', 'contempo') . '</h5>';

                    ct_google_places_nearby('hospital', $ct_listing_lat_long);
                    
                break;

                // Gas Stations           
                case 'gas_station' :

                    echo '<h5><i class="fa fa-car"></i> ' . __('Gas Stations', 'contempo') . '</h5>';

                    ct_google_places_nearby('gas_station', $ct_listing_lat_long);
                    
                break;

                // Transit Stations           
                case 'transit_station' :

                    echo '<h5><i class="fa fa-bus"></i> ' . __('Transit Stations', 'contempo') . '</h5>';

                    ct_google_places_nearby('transit_station', $ct_listing_lat_long);
                    
                break;

                // Convenience Stores          
                case 'convenience_store' :

                    echo '<h5><i class="fa fa-building-o"></i> ' . __('Convenience Stores', 'contempo') . '</h5>';

                    ct_google_places_nearby('convenience_store', $ct_listing_lat_long);
                    
                break;

                // Shopping Malls        
                case 'shopping_mall' :

                    echo '<h5><i class="fa fa-shopping-bag"></i> ' . __('Shopping Malls', 'contempo') . '</h5>';

                    ct_google_places_nearby('shopping_mall', $ct_listing_lat_long);
                    
                break;

                // Vetinary Care       
                case 'veterinary_care' :

                    echo '<h5><i class="fa fa-hospital-o"></i> ' . __('Veterinary Care', 'contempo') . '</h5>';

                    ct_google_places_nearby('veterinary_care', $ct_listing_lat_long);
                    
                break;

                // Pet Store       
                case 'pet_store' :

                    echo '<h5><i class="fa fa-paw"></i> ' . __('Pet Store', 'contempo') . '</h5>';

                    ct_google_places_nearby('pet_store', $ct_listing_lat_long);
                    
                break;

                // Park       
                case 'park' :

                    echo '<h5><i class="fa fa-tree"></i> ' . __('Park', 'contempo') . '</h5>';

                    ct_google_places_nearby('park', $ct_listing_lat_long);
                    
                break;

            }

        } endif;

    echo '</div>';
} else {
    echo '<div class="nomatches">';
        echo '<h5>' . __('Google Places/What\'s Nearby? Error.', 'contempo') . '</h5>';
        echo '<p class="marB0">' . __('You need to create an API key go into Admin > Real Estate 7 Options > Google Maps > API Key, then setup the options via Real Estate 7 Options > "What\'s Nearby?" panel.', 'contempo') . '</p>';
    echo '</div>';
}
echo '<!-- // Nearby -->';

?>