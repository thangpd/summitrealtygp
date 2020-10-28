<?php
/**
 * Single Listing Multi Floorplan
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';

$ct_multi_floorplan = isset( $ct_options['ct_multi_floorplan'] ) ? esc_attr( $ct_options['ct_multi_floorplan'] ) : '';

if($ct_multi_floorplan == 'yes') {
    echo '<!-- Multi Floor Plan -->';
    echo '<div id="listing-plans">';
        $ct_floor_entries = get_post_meta( get_the_ID(), '_ct_multiplan', true );
        $ct_currency_placement = isset( $ct_options['ct_currency_placement'] ) ? esc_html( $ct_options['ct_currency_placement'] ) : '';

        if($ct_floor_entries != '') {

            if($ct_single_listing_content_layout_type == 'accordion') {
                echo '<h4 id="listing-floor-plans" class="info-toggle border-bottom marB20">' . __('Floor Plans & Pricing', 'contempo') . '</h4>';
            } else {
                echo '<h4 id="listing-floor-plans" class="border-bottom marB20">' . __('Floor Plans & Pricing', 'contempo') . '</h4>';
            }

            echo '<div class="info-inner">';
                echo '<table id="multi-floor-plan">';

                    echo '<thead>';
                        echo '<th>';
                            echo __('Name', 'contempo');
                        echo '</th>';
                        if(ct_has_type('commercial') || ct_has_type('industrial') || ct_has_type('retail') || ct_has_type('lot') || ct_has_type('land')) { 
                           // Dont display beds/baths
                        } else {
                             echo '<th>';
                                echo __('Beds', 'contempo');
                            echo '</th>';
                            echo '<th>';
                                echo __('Baths', 'contempo');
                            echo '</th>';
                        }
                        echo '<th>';
                            echo __('Size', 'contempo');
                        echo '</th>';
                        echo '<th>';
                            echo __('Price', 'contempo');
                        echo '</th>';
                        echo '<th>';
                            echo __('Availability', 'contempo');
                        echo '</th>';
                        echo '<th>';
                            echo esc_html('&nbsp;');
                        echo '</th>';
                    echo '</thead>';

                    foreach ( (array) $ct_floor_entries as $key => $entry ) {

                        $ct_plan_img = $ct_plan_title = $ct_plan_beds = $ct_plan_baths = $ct_plan_size = $ct_plan_price = $ct_plan_desc = '';

                        if ( isset( $entry['_ct_plan_title'] ) )
                            $ct_plan_title = esc_html( $entry['_ct_plan_title'] );

                        if(ct_has_type('commercial') || ct_has_type('industrial') || ct_has_type('retail') || ct_has_type('lot') || ct_has_type('land')) { 
                           // Dont display beds/baths
                        } else {
                            if ( isset( $entry['_ct_plan_beds'] ) )
                                $ct_plan_beds = esc_html( $entry['_ct_plan_beds'] );

                            if ( isset( $entry['_ct_plan_baths'] ) )
                                $ct_plan_baths = esc_html( $entry['_ct_plan_baths'] );
                        }

                        if ( isset( $entry['_ct_plan_size'] ) )
                            $ct_plan_size = esc_html( $entry['_ct_plan_size'] );

                        if ( isset( $entry['_ct_plan_price'] ) )
                            $ct_plan_price = esc_html( $entry['_ct_plan_price'] );
                            $ct_plan_price= preg_replace('/[\$,]/', '', $ct_plan_price);

                        if ( isset( $entry['_ct_plan_availability'] ) )
                            $ct_plan_availability = $entry['_ct_plan_availability'];

                        if ( isset( $entry['_ct_plan_image'] ) ) {
                            $ct_plan_image = $entry['_ct_plan_image'];
                        }

                        echo '<tr>';
                            echo '<td>';
                                if($ct_plan_image != '') {
                                echo '<a href="' . $ct_plan_image . '" class="floorplans">';
                                    echo esc_html($ct_plan_title);
                                echo '</a>';
                                } else {
                                    echo esc_html($ct_plan_title);
                                }
                            echo '</td>';
                            if(ct_has_type('commercial') || ct_has_type('industrial') || ct_has_type('retail') || ct_has_type('lot') || ct_has_type('land')) { 
                               // Dont display beds/baths
                            } else {
                                echo '<td>';
                                    echo esc_html($ct_plan_beds);
                                echo '</td>';
                                echo '<td>';
                                    echo esc_html($ct_plan_baths);
                                echo '</td>';
                            }
                            echo '<td>';
                                echo esc_html($ct_plan_size);
                            echo '</td>';
                            echo '<td>';
                                if($ct_currency_placement == 'after') {
                                    echo esc_html($ct_plan_price);
                                    ct_currency();
                                } else {
                                    ct_currency();
                                    echo esc_html($ct_plan_price);
                                }
                            echo '</td>';
                            echo '<td>';
                                echo esc_html($ct_plan_availability);
                            echo '</td>';
                            if($ct_plan_image != '') {
                                echo '<td>';
                                    echo '<a class="btn gallery-item" href="' . $ct_plan_image . '">';
                                        echo __('View', 'contempo');
                                    echo '</a>';
                                echo '</td>';
                            }
                        echo '</tr>';
                    }

                echo '</table>';
            echo '</div>';

        }
    echo '</div>';
    echo '<!-- //Multi Floor Plan -->';
}

?>