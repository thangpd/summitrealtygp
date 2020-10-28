<?php
/**
 * Single Listing CT IDX Pro Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';

$ct_single_listing_idx_layout = isset( $ct_options['ct_single_listing_idx_layout']['enabled'] ) ? $ct_options['ct_single_listing_idx_layout']['enabled'] : '';

$ct_source = get_post_meta($post->ID, 'source', true);

$ct_status = get_post_meta($post->ID, "_ct_status", true);
$ct_sold_date = get_post_meta($post->ID, "_ct_sold_date", true);
$ct_neighborhood = get_post_meta($post->ID, "_ct_idx_overview_neighborhood", true);
$ct_subdivision = get_post_meta($post->ID, "_ct_idx_overview_subdivision", true);
$ct_style = get_post_meta($post->ID, "_ct_idx_overview_style", true);
$ct_year_built = get_post_meta($post->ID, "_ct_idx_overview_year_built", true);
$ct_fencing = get_post_meta($post->ID, "_ct_idx_overview_fencing", true);
$ct_topography = get_post_meta($post->ID, "_ct_idx_overview_topography", true);
$ct_lot_sqft = get_post_meta($post->ID, "_ct_idx_overview_lot_square_feet", true);
$ct_exterior = get_post_meta($post->ID, "_ct_idx_overview_exterior", true);
$ct_roofing = get_post_meta($post->ID, "_ct_idx_overview_roofing", true);
$ct_structures = get_post_meta($post->ID, "_ct_idx_overview_structures", true);
$ct_parking = get_post_meta($post->ID, "_ct_idx_overview_parking_garage", true);
$ct_parking_spaces = get_post_meta($post->ID, "_ct_idx_overview_parking_garage_spaces", true);
$ct_garage_stalls = get_post_meta($post->ID, "_ct_idx_overview_garage_type_stalls", true);
$ct_idx_overview_utilities_available = get_post_meta($post->ID, "_ct_idx_overview_utilities_available", true);
$ct_heating = get_post_meta($post->ID, "_ct_idx_overview_heating", true);
$ct_heating_primary = get_post_meta($post->ID, "_ct_idx_overview_primary_heat", true);
$ct_heat_source = get_post_meta($post->ID, "_ct_idx_overview_heat_source", true);
$ct_cooling = get_post_meta($post->ID, "_ct_idx_overview_cooling", true);
$ct_water = get_post_meta($post->ID, "_ct_idx_overview_water", true);
$ct_sewer_septic = get_post_meta($post->ID, "_ct_idx_overview_sewer_septic", true);

$ct_exterior_features = get_post_meta($post->ID, "_ct_idx_features_exterior_features", true);
$ct_interior_features = get_post_meta($post->ID, "_ct_idx_features_interior_features", true);
$ct_idx_features_miscellaneous_features = get_post_meta($post->ID, "_ct_idx_features_miscellaneous_features", true);
$ct_equipment = get_post_meta($post->ID, "_ct_idx_features_equipment", true);
$ct_fireplace = get_post_meta($post->ID, "_ct_idx_features_fireplace", true);
$ct_fireplace_type = get_post_meta($post->ID, "_ct_idx_features_fireplace_type", true);
$ct_num_of_fireplaces = get_post_meta($post->ID, "_ct_idx_features_number_of_fireplaces", true);
$ct_pool = get_post_meta($post->ID, "_ct_idx_features_pool", true);
$ct_view = get_post_meta($post->ID, "_ct_idx_features_view", true);
$ct_security = get_post_meta($post->ID, "_ct_security", true);
$ct_floor_coverings = get_post_meta($post->ID, "_ct_floor_coverings", true);

$ct_idx_room_info_bedrooms = get_post_meta($post->ID, "_ct_idx_room_info_bedrooms", true);
$ct_idx_room_info_total_full_baths = get_post_meta($post->ID, "_ct_idx_room_info_total_full_baths", true);
$ct_idx_room_info_total_3_4_baths = get_post_meta($post->ID, "_ct_idx_room_info_total_3_4_baths", true);
$ct_idx_room_info_total_1_2_baths = get_post_meta($post->ID, "_ct_idx_room_info_total_1_2_baths", true);
$ct_idx_room_info_basement_type = get_post_meta($post->ID, "_ct_idx_room_info_basement_type", true);

$ct_idx_schools_school_district = get_post_meta($post->ID, "_ct_idx_schools_school_district", true);
$ct_idx_schools_elementary_school = get_post_meta($post->ID, "_ct_idx_schools_elementary_school", true);
$ct_idx_schools_middle_school = get_post_meta($post->ID, "_ct_idx_schools_middle_school", true);
$ct_idx_schools_high_school = get_post_meta($post->ID, "_ct_idx_schools_high_school", true);

$ct_hoa_fee = get_post_meta($post->ID, "_ct_idx_financial_hoa_fee", true);
$ct_hoa_fee_due = get_post_meta($post->ID, "_ct_idx_financial_hoa_fee_due", true);
$ct_hoa_includes = get_post_meta($post->ID, "_ct_hoa_includes", true);
$ct_idx_features_hoa_fee_includes = get_post_meta($post->ID, "_ct_idx_features_hoa_fee_includes", true);


function ct_idx_info($field) {
    global $post;

    $ct_field = get_post_meta($post->ID, $field, true);

    if(is_array($ct_field)) {
        echo implode(',', array_map('ucwords', $ct_field));
    } else {
        echo ucwords(esc_html($ct_field));
    }
}

do_action('before_single_listing_ct_idx_pro_info');

if($ct_source == 'idx-api') {

    echo '<!-- Listing IDX Info -->';
    echo '<div id="listing-idx-info">';

    if(!empty($ct_single_listing_idx_layout)) {

        foreach ($ct_single_listing_idx_layout as $key => $value) {
        
            switch($key) {

                // Content
                case 'listing_idx_overview' :   

                    if(!empty($ct_status) || !empty($ct_neighborhood) || !empty($ct_subdivision) || !empty($ct_style) || !empty($ct_year_built) || !empty($ct_fencing) || !empty($ct_topography) || !empty($ct_lot_sqft) || !empty($ct_exterior) || !empty($ct_roofing) || !empty($ct_structures) || !empty($ct_parking) || !empty($ct_parking_spaces) || !empty($ct_garage_stalls) || !empty($ct_idx_overview_utilities_available) || !empty($ct_heating) || !empty($ct_heating_primary) || !empty($ct_heat_source) || !empty($ct_cooling) || !empty($ct_water) || !empty($ct_sewer_septic)) {

                            if($ct_single_listing_content_layout_type == 'accordion') {
                                echo '<h4 id="idx-overview" class="info-toggle border-bottom marB20">' . __('Overview', 'contempo') . '</h4>';
                            } else {
                                echo '<h4 id="idx-overview" class="border-bottom marB20">' . __('Overview', 'contempo') . '</h4>';
                            }
                            echo '<div class="info-inner">';
                                echo '<ul class="propinfo idx-info col span_6 first">';

                                    if(!empty($ct_status)) {
                                        echo '<li class="row status">';
                                            echo '<span class="muted left">';
                                                _e('Status', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_status');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_sold_date)) {
                                        echo '<li class="row sold-date">';
                                            echo '<span class="muted left">';
                                                _e('Sold Date', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_sold_date');
                                            echo '</span>';
                                        echo '</li>';
                                    }
                                    
                                    if(!empty($ct_neighborhood)) {
                                        echo '<li class="row neighborhood">';
                                            echo '<span class="muted left">';
                                                _e('Neighborhood', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_neighborhood');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_subdivision)) {
                                        echo '<li class="row subdivision">';
                                            echo '<span class="muted left">';
                                                _e('Subdivision', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_subdivision');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_style)) {
                                        echo '<li class="row style">';
                                            echo '<span class="muted left">';
                                                _e('Style', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_style');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_year_built)) {
                                        echo '<li class="row year-built">';
                                            echo '<span class="muted left">';
                                                _e('Year Built', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_year_built');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_fencing)) {
                                        echo '<li class="row fencing">';
                                            echo '<span class="muted left">';
                                                _e('Fencing', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_fencing');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_topography)) {
                                        echo '<li class="row topography">';
                                            echo '<span class="muted left">';
                                                _e('Topography', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_topography');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_lot_sqft)) {
                                        echo '<li class="row lot-sqft">';
                                            echo '<span class="muted left">';
                                                _e('Lot Sq Ft', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_lot_square_feet');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_exterior)) {
                                        echo '<li class="row exterior">';
                                            echo '<span class="muted left">';
                                                _e('Exterior', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                ct_idx_info('_ct_idx_overview_exterior');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_roofing)) {
                                        echo '<li class="row roofing">';
                                            echo '<span class="muted left">';
                                                _e('Roofing', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                ct_idx_info('_ct_idx_overview_roofing');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    echo '</ul>';
                                    echo '<ul class="propinfo idx-info col span_6" style="margin-left: 2%;">';

                                    if(!empty($ct_structures)) {
                                        echo '<li class="row structures">';
                                            echo '<span class="muted left">';
                                                _e('Structures', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                ct_idx_info('_ct_idx_overview_structures');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_parking)) {
                                        echo '<li class="row parking">';
                                            echo '<span class="muted left">';
                                                _e('Parking/Garage', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_parking_garage');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_parking_spaces)) {
                                        echo '<li class="row parking-spaces">';
                                            echo '<span class="muted left">';
                                                _e('Parking/Garage Spaces', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_parking_garage_spaces');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_garage_stalls)) {
                                        echo '<li class="row parking-spaces">';
                                            echo '<span class="muted left">';
                                                _e('Garage Stalls', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_garage_type_stalls');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_idx_overview_utilities_available)) {
                                        echo '<li class="row utilities">';
                                            echo '<span class="muted left">';
                                                _e('Utilities', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                ct_idx_info('_ct_idx_overview_utilities_available');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_heating)) {
                                        echo '<li class="row heating">';
                                            echo '<span class="muted left">';
                                                _e('Heating', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                ct_idx_info('_ct_idx_overview_heating');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_heating_primary)) {
                                        echo '<li class="row heating-primary">';
                                            echo '<span class="muted left">';
                                                _e('Primary Heating', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                ct_idx_info('_ct_idx_overview_primary_heat');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_heat_source)) {
                                        echo '<li class="row heat-source">';
                                            echo '<span class="muted left">';
                                                _e('Heat Source', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_heat_source');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_cooling)) {
                                        echo '<li class="row cooling">';
                                            echo '<span class="muted left">';
                                                _e('Cooling', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_cooling');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_water)) {
                                        echo '<li class="row water">';
                                            echo '<span class="muted left">';
                                                _e('Water', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_water');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                    if(!empty($ct_sewer_septic)) {
                                        echo '<li class="row sewer-septic">';
                                            echo '<span class="muted left">';
                                                _e('Sewer/Septic', 'contempo');
                                            echo '</span>';
                                            echo '<span class="right">';
                                                 ct_idx_info('_ct_idx_overview_sewer_septic');
                                            echo '</span>';
                                        echo '</li>';
                                    }

                                echo '</ul>';
                                echo '<div class="clear"></div>';
                            echo '</div>';
                            echo '<!-- //Listing IDX Info -->';

                        }
            
                break;

                // Features
                case 'listing_idx_features' :   

                    if(!empty($ct_exterior_features) || !empty($ct_interior_features) || !empty($ct_idx_features_miscellaneous_features) || !empty($ct_equipment) || !empty($ct_fireplace) || !empty($ct_fireplace_type) || !empty($ct_num_of_fireplaces) || !empty($ct_pool) || !empty($ct_view) || !empty($ct_security) || !empty($ct_floor_coverings)) { 
                        echo '<!-- Listing IDX Features -->';
                        if($ct_single_listing_content_layout_type == 'accordion') {
                            echo '<h4 id="idx-features" class="info-toggle border-bottom marB20">' . __('Features', 'contempo') . '</h4>';
                        } else {
                            echo '<h4 id="idx-features" class="border-bottom marB20">' . __('Features', 'contempo') . '</h4>';
                        }
                        echo '<div class="info-inner">';
                            echo '<ul class="propinfo idx-info col span_6 marB0">';

                                if(!empty($ct_exterior_features)) {
                                    echo '<li class="row exterior-features">';
                                        echo '<span class="muted left">';
                                            _e('Exterior', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_idx_features_exterior_features');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_interior_features)) {
                                    echo '<li class="row interior-features">';
                                        echo '<span class="muted left">';
                                            _e('Interior', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_idx_features_interior_features');
                                        echo '</span>';
                                    echo '</li>';
                                }
                                
                                if(!empty($ct_equipment)) {
                                    echo '<li class="row equipment">';
                                        echo '<span class="muted left">';
                                            _e('Equipment', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_idx_features_equipment');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_idx_features_miscellaneous_features)) {
                                    echo '<li class="row misc-features">';
                                        echo '<span class="muted left">';
                                            _e('Misc', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_idx_features_miscellaneous_features');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_fireplace)) {
                                    echo '<li class="row fireplace">';
                                        echo '<span class="muted left">';
                                            _e('Fireplace', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_idx_features_fireplace');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_fireplace_type)) {
                                    echo '<li class="row fireplace-type">';
                                        echo '<span class="muted left">';
                                            _e('Fireplace Type', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_idx_features_fireplace_type');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                echo '</ul>';
                                echo '<ul class="propinfo idx-info col span_6" style="margin-left: 2%;">';
                                
                                if(!empty($ct_num_of_fireplaces)) {
                                    echo '<li class="row num-of-fireplaces">';
                                        echo '<span class="muted left">';
                                            _e('Number of Fireplaces', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_features_number_of_fireplaces');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_pool)) {
                                    echo '<li class="row pool">';
                                        echo '<span class="muted left">';
                                            _e('Pool', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_features_pool');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_view)) {
                                    echo '<li class="row view">';
                                        echo '<span class="muted left">';
                                            _e('View', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_idx_features_view');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_security)) {
                                    echo '<li class="row security">';
                                        echo '<span class="muted left">';
                                            _e('Security', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_security');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_floor_coverings)) {
                                    echo '<li class="row floor-coverings">';
                                        echo '<span class="muted left">';
                                            _e('Floor Coverings', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                            ct_idx_info('_ct_floor_coverings');
                                        echo '</span>';
                                    echo '</li>';
                                }

                            echo '</ul>';
                                echo '<div class="clear"></div>';
                        echo '</div>';
                        echo '<!-- //Listing IDX Features -->';
                    }
            
                break;

                // Rooms
                case 'listing_idx_rooms' :   

                    if(!empty($ct_idx_room_info_bedrooms) || !empty($ct_idx_room_info_total_full_baths) || !empty($ct_idx_room_info_total_3_4_baths) || !empty($ct_idx_room_info_total_1_2_baths) || !empty($ct_idx_room_info_basement_type)) { 
                        echo '<!-- Listing IDX Rooms -->';
                        if($ct_single_listing_content_layout_type == 'accordion') {
                            echo '<h4 id="idx-rooms" class="info-toggle border-bottom marB20">' . __('Rooms', 'contempo') . '</h4>';
                        } else {
                            echo '<h4 id="idx-rooms" class="border-bottom marB20">' . __('Rooms', 'contempo') . '</h4>';
                        }
                        echo '<div class="info-inner">';
                            echo '<ul class="propinfo idx-info col span_6 marB0">';
                                
                                if(!empty($ct_idx_room_info_bedrooms)) {
                                    echo '<li class="row bedrooms">';
                                        echo '<span class="muted left">';
                                            _e('Bedrooms', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_room_info_bedrooms');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_idx_room_info_total_full_baths)) {
                                    echo '<li class="row full-baths">';
                                        echo '<span class="muted left">';
                                            _e('Full Baths', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_room_info_total_full_baths');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_idx_room_info_total_3_4_baths)) {
                                    echo '<li class="row three-quarter-baths">';
                                        echo '<span class="muted left">';
                                            _e('3/4 Baths', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_room_info_total_3_4_baths');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                echo '</ul>';
                                echo '<ul class="propinfo idx-info col span_6" style="margin-left: 2%;">';

                                if(!empty($ct_idx_room_info_total_1_2_baths)) {
                                    echo '<li class="row half-baths">';
                                        echo '<span class="muted left">';
                                            _e('1/2 Baths', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_room_info_total_1_2_baths');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_idx_room_info_basement_type)) {
                                    echo '<li class="row basement">';
                                        echo '<span class="muted left">';
                                            _e('Basement', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_room_info_basement_type');
                                        echo '</span>';
                                    echo '</li>';
                                }

                            echo '</ul>';
                                echo '<div class="clear"></div>';
                        echo '</div>';
                        echo '<!-- //Listing IDX Rooms -->';
                    }
            
                break;

                // Schools
                case 'listing_idx_schools' :   

                    if(!empty($ct_idx_schools_school_district) || !empty($ct_idx_schools_elementary_school) || !empty($ct_idx_schools_middle_school) || !empty($ct_idx_schools_high_school)) { 
                        echo '<!-- Listing IDX Schools -->';
                        if($ct_single_listing_content_layout_type == 'accordion') {
                            echo '<h4 id="idx-schools" class="info-toggle border-bottom marB20">' . __('Schools', 'contempo') . '</h4>';
                        } else {
                            echo '<h4 id="idx-schools" class="border-bottom marB20">' . __('Schools', 'contempo') . '</h4>';
                        }
                        echo '<div class="info-inner">';
                            echo '<ul class="propinfo idx-info col span_6 marB0">';
                                
                                if(!empty($ct_idx_schools_school_district)) {
                                    echo '<li class="row district">';
                                        echo '<span class="muted left">';
                                            _e('District', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_schools_school_district');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_idx_schools_elementary_school)) {
                                    echo '<li class="row elementary-school">';
                                        echo '<span class="muted left">';
                                            _e('Elementary', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_schools_elementary_school');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                echo '</ul>';
                                echo '<ul class="propinfo idx-info col span_6" style="margin-left: 2%;">';

                                if(!empty($ct_idx_schools_middle_school)) {
                                    echo '<li class="row middle-school">';
                                        echo '<span class="muted left">';
                                            _e('Middle', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_schools_middle_school');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_idx_schools_high_school)) {
                                    echo '<li class="row high-school">';
                                        echo '<span class="muted left">';
                                            _e('High', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_schools_high_school');
                                        echo '</span>';
                                    echo '</li>';
                                }

                            echo '</ul>';
                                echo '<div class="clear"></div>';
                        echo '</div>';
                        echo '<!-- //Listing IDX Schools -->';
                    }
            
                break;

                // HOA
                case 'listing_idx_hoa' :   

                    if(!empty($ct_hoa_fee) || !empty($ct_hoa_fee_due) || !empty($ct_hoa_includes) || !empty($ct_idx_features_hoa_fee_includes)) { 
                        echo '<!-- Listing IDX HOA -->';
                        if($ct_single_listing_content_layout_type == 'accordion') {
                            echo '<h4 id="idx-hoa" class="info-toggle border-bottom marB20">' . __('HOA', 'contempo') . '</h4>';
                        } else {
                            echo '<h4 id="idx-hoa" class="border-bottom marB20">' . __('HOA', 'contempo') . '</h4>';
                        }
                        echo '<div class="info-inner">';
                            echo '<ul class="propinfo idx-info marB0">';
                                
                                if(!empty($_ct_hoa_fee)) {
                                    echo '<li class="row hoa-fee">';
                                        echo '<span class="muted left">';
                                            _e('HOA', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_hoa_fee');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_hoa_fee_due)) {
                                    echo '<li class="row hoa-fee-due">';
                                        echo '<span class="muted left">';
                                            _e('HOA Fee Due', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_hoa_fee_due');
                                        echo '</span>';
                                    echo '</li>';
                                }

                                if(!empty($ct_idx_features_hoa_fee_includes)) {
                                    echo '<li class="row hoa-includes">';
                                        echo '<span class="muted left">';
                                            _e('HOA Includes', 'contempo');
                                        echo '</span>';
                                        echo '<span class="right">';
                                             ct_idx_info('_ct_idx_features_hoa_fee_includes');
                                        echo '</span>';
                                    echo '</li>';
                                }

                            echo '</ul>';
                                echo '<div class="clear"></div>';
                        echo '</div>';
                        echo '<!-- //Listing IDX HOA -->';
                    }
            
                break;

            
            }

        }


    } else {

        // For Legacy Users

        if(!empty($ct_status) || !empty($ct_neighborhood) || !empty($ct_subdivision) || !empty($ct_style) || !empty($ct_year_built) || !empty($ct_fencing) || !empty($ct_topography) || !empty($ct_lot_sqft) || !empty($ct_exterior) || !empty($ct_roofing) || !empty($ct_structures) || !empty($ct_parking) || !empty($ct_parking_spaces) || !empty($ct_garage_stalls) || !empty($ct_idx_overview_utilities_available) || !empty($ct_heating) || !empty($ct_heating_primary) || !empty($ct_heat_source) || !empty($ct_cooling) || !empty($ct_water) || !empty($ct_sewer_septic)) {

            echo '<!-- Listing IDX Info -->';
            echo '<div id="listing-idx-info">';
                echo '<h4 class="border-bottom marB20">' . __('Overview', 'contempo') . '</h4>';
                echo '<ul class="propinfo idx-info marB0">';

                    if(!empty($ct_status)) {
                        echo '<li class="row status">';
                            echo '<span class="muted left">';
                                _e('Status', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_status');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_sold_date)) {
                        echo '<li class="row sold-date">';
                            echo '<span class="muted left">';
                                _e('Sold Date', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_sold_date');
                            echo '</span>';
                        echo '</li>';
                    }
                    
                    if(!empty($ct_neighborhood)) {
                        echo '<li class="row neighborhood">';
                            echo '<span class="muted left">';
                                _e('Neighborhood', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_neighborhood');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_subdivision)) {
                        echo '<li class="row subdivision">';
                            echo '<span class="muted left">';
                                _e('Subdivision', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_subdivision');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_style)) {
                        echo '<li class="row style">';
                            echo '<span class="muted left">';
                                _e('Style', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_style');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_year_built)) {
                        echo '<li class="row year-built">';
                            echo '<span class="muted left">';
                                _e('Year Built', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_year_built');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_fencing)) {
                        echo '<li class="row fencing">';
                            echo '<span class="muted left">';
                                _e('Fencing', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_fencing');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_topography)) {
                        echo '<li class="row topography">';
                            echo '<span class="muted left">';
                                _e('Topography', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_topography');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_lot_sqft)) {
                        echo '<li class="row lot-sqft">';
                            echo '<span class="muted left">';
                                _e('Lot Sq Ft', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_lot_square_feet');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_exterior)) {
                        echo '<li class="row exterior">';
                            echo '<span class="muted left">';
                                _e('Exterior', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_overview_exterior');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_roofing)) {
                        echo '<li class="row roofing">';
                            echo '<span class="muted left">';
                                _e('Roofing', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_overview_roofing');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_structures)) {
                        echo '<li class="row structures">';
                            echo '<span class="muted left">';
                                _e('Structures', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_overview_structures');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_parking)) {
                        echo '<li class="row parking">';
                            echo '<span class="muted left">';
                                _e('Parking/Garage', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_parking_garage');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_parking_spaces)) {
                        echo '<li class="row parking-spaces">';
                            echo '<span class="muted left">';
                                _e('Parking/Garage Spaces', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_parking_garage_spaces');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_garage_stalls)) {
                        echo '<li class="row parking-spaces">';
                            echo '<span class="muted left">';
                                _e('Garage Stalls', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_garage_type_stalls');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_overview_utilities_available)) {
                        echo '<li class="row utilities">';
                            echo '<span class="muted left">';
                                _e('Utilities', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_overview_utilities_available');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_heating)) {
                        echo '<li class="row heating">';
                            echo '<span class="muted left">';
                                _e('Heating', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_overview_heating');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_heating_primary)) {
                        echo '<li class="row heating-primary">';
                            echo '<span class="muted left">';
                                _e('Primary Heating', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_overview_primary_heat');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_heat_source)) {
                        echo '<li class="row heat-source">';
                            echo '<span class="muted left">';
                                _e('Heat Source', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_heat_source');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_cooling)) {
                        echo '<li class="row cooling">';
                            echo '<span class="muted left">';
                                _e('Cooling', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_cooling');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_water)) {
                        echo '<li class="row water">';
                            echo '<span class="muted left">';
                                _e('Water', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_water');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_sewer_septic)) {
                        echo '<li class="row sewer-septic">';
                            echo '<span class="muted left">';
                                _e('Sewer/Septic', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_overview_sewer_septic');
                            echo '</span>';
                        echo '</li>';
                    }

                echo '</ul>';
                echo '<!-- //Listing IDX Info -->';

            }

            if(!empty($ct_exterior_features) || !empty($ct_interior_features) || !empty($ct_idx_features_miscellaneous_features) || !empty($ct_equipment) || !empty($ct_fireplace) || !empty($ct_fireplace_type) || !empty($ct_num_of_fireplaces) || !empty($ct_pool) || !empty($ct_view) || !empty($ct_security) || !empty($ct_floor_coverings)) { 
                echo '<!-- Listing IDX Features -->';
                echo '<h4 class="border-bottom marB20">' . __('Features', 'contempo') . '</h4>';
                echo '<ul class="propinfo idx-info marB0">';

                    if(!empty($ct_exterior_features)) {
                        echo '<li class="row exterior-features">';
                            echo '<span class="muted left">';
                                _e('Exterior', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_features_exterior_features');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_interior_features)) {
                        echo '<li class="row interior-features">';
                            echo '<span class="muted left">';
                                _e('Interior', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_features_interior_features');
                            echo '</span>';
                        echo '</li>';
                    }
                    
                    if(!empty($ct_equipment)) {
                        echo '<li class="row equipment">';
                            echo '<span class="muted left">';
                                _e('Equipment', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_features_equipment');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_features_miscellaneous_features)) {
                        echo '<li class="row misc-features">';
                            echo '<span class="muted left">';
                                _e('Misc', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_features_miscellaneous_features');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_fireplace)) {
                        echo '<li class="row fireplace">';
                            echo '<span class="muted left">';
                                _e('Fireplace', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_features_fireplace');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_fireplace_type)) {
                        echo '<li class="row fireplace-type">';
                            echo '<span class="muted left">';
                                _e('Fireplace Type', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_features_fireplace_type');
                            echo '</span>';
                        echo '</li>';
                    }
                    
                    if(!empty($ct_num_of_fireplaces)) {
                        echo '<li class="row num-of-fireplaces">';
                            echo '<span class="muted left">';
                                _e('Number of Fireplaces', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_features_number_of_fireplaces');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_pool)) {
                        echo '<li class="row pool">';
                            echo '<span class="muted left">';
                                _e('Pool', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_features_pool');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_view)) {
                        echo '<li class="row view">';
                            echo '<span class="muted left">';
                                _e('View', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_idx_features_view');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_security)) {
                        echo '<li class="row security">';
                            echo '<span class="muted left">';
                                _e('Security', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_security');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_floor_coverings)) {
                        echo '<li class="row floor-coverings">';
                            echo '<span class="muted left">';
                                _e('Floor Coverings', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                ct_idx_info('_ct_floor_coverings');
                            echo '</span>';
                        echo '</li>';
                    }

                echo '</ul>';
                echo '<!-- //Listing IDX Features -->';
            }

            if(!empty($ct_idx_room_info_bedrooms) || !empty($ct_idx_room_info_total_full_baths) || !empty($ct_idx_room_info_total_3_4_baths) || !empty($ct_idx_room_info_total_1_2_baths) || !empty($ct_idx_room_info_basement_type)) { 
                echo '<!-- Listing IDX Rooms -->';
                echo '<h4 class="border-bottom marB20">' . __('Rooms', 'contempo') . '</h4>';
                echo '<ul class="propinfo idx-info marB0">';
                    
                    if(!empty($ct_idx_room_info_bedrooms)) {
                        echo '<li class="row bedrooms">';
                            echo '<span class="muted left">';
                                _e('Bedrooms', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_room_info_bedrooms');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_room_info_total_full_baths)) {
                        echo '<li class="row full-baths">';
                            echo '<span class="muted left">';
                                _e('Full Baths', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_room_info_total_full_baths');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_room_info_total_3_4_baths)) {
                        echo '<li class="row three-quarter-baths">';
                            echo '<span class="muted left">';
                                _e('3/4 Baths', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_room_info_total_3_4_baths');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_room_info_total_1_2_baths)) {
                        echo '<li class="row half-baths">';
                            echo '<span class="muted left">';
                                _e('1/2 Baths', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_room_info_total_1_2_baths');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_room_info_basement_type)) {
                        echo '<li class="row basement">';
                            echo '<span class="muted left">';
                                _e('Basement', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_room_info_basement_type');
                            echo '</span>';
                        echo '</li>';
                    }

                echo '</ul>';
                echo '<!-- //Listing IDX Rooms -->';
            }

            if(!empty($ct_idx_schools_school_district) || !empty($ct_idx_schools_elementary_school) || !empty($ct_idx_schools_middle_school) || !empty($ct_idx_schools_high_school)) { 
                echo '<!-- Listing IDX Schools -->';
                echo '<h4 class="border-bottom marB20">' . __('Schools', 'contempo') . '</h4>';
                echo '<ul class="propinfo idx-info marB0">';
                    
                    if(!empty($ct_idx_schools_school_district)) {
                        echo '<li class="row district">';
                            echo '<span class="muted left">';
                                _e('District', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_schools_school_district');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_schools_elementary_school)) {
                        echo '<li class="row elementary-school">';
                            echo '<span class="muted left">';
                                _e('Elementary', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_schools_elementary_school');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_schools_middle_school)) {
                        echo '<li class="row middle-school">';
                            echo '<span class="muted left">';
                                _e('Middle', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_schools_middle_school');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_schools_high_school)) {
                        echo '<li class="row high-school">';
                            echo '<span class="muted left">';
                                _e('High', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_schools_high_school');
                            echo '</span>';
                        echo '</li>';
                    }

                echo '</ul>';
                echo '<!-- //Listing IDX Schools -->';
            }

            if(!empty($ct_hoa_fee) || !empty($ct_hoa_fee_due) || !empty($ct_hoa_includes) || !empty($ct_idx_features_hoa_fee_includes)) { 
                echo '<!-- Listing IDX HOA -->';
                echo '<h4 class="border-bottom marB20">' . __('HOA', 'contempo') . '</h4>';
                echo '<ul class="propinfo idx-info marB0">';
                    
                    if(!empty($_ct_hoa_fee)) {
                        echo '<li class="row hoa-fee">';
                            echo '<span class="muted left">';
                                _e('HOA', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_hoa_fee');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_hoa_fee_due)) {
                        echo '<li class="row hoa-fee-due">';
                            echo '<span class="muted left">';
                                _e('HOA Fee Due', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_hoa_fee_due');
                            echo '</span>';
                        echo '</li>';
                    }

                    if(!empty($ct_idx_features_hoa_fee_includes)) {
                        echo '<li class="row hoa-includes">';
                            echo '<span class="muted left">';
                                _e('HOA Includes', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                                 ct_idx_info('_ct_idx_features_hoa_fee_includes');
                            echo '</span>';
                        echo '</li>';
                    }

                echo '</ul>';
                echo '<!-- //Listing IDX HOA -->';
            }

        }

    echo '</div>';
        
    }

?>