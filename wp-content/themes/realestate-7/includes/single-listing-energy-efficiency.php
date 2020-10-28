<?php
/**
 * Single Listing Energy Efficiency
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';

$ct_energy_class = get_post_meta($post->ID, "_ct_energy_class", true);
$ct_global_energy_performance_index = get_post_meta($post->ID, "_ct_global_energy_performance_index", true);
$ct_renewable_energy_performance_index = get_post_meta($post->ID, "_ct_renewable_energy_performance_index", true);
$ct_building_energy_performance = get_post_meta($post->ID, "_ct_building_energy_performance", true);

do_action('before_single_listing_energy_efficiency');

if(!empty($ct_energy_class) || !empty($ct_global_energy_performance_index) || !empty($ct_renewable_energy_performance_index) || !empty($ct_building_energy_performance)) {
    echo '<!-- Energy Efficiency -->';
    echo '<div id="listing-renergy-efficiency">';
        if($ct_single_listing_content_layout_type == 'accordion') {
            echo '<h4 id="energy-efficiency" class="info-toggle border-bottom marB20">' . __('Energy Efficiency', 'contempo') . '</h4>';
        } else {
             echo '<h4 id="energy-efficiency" class="border-bottom marB20">' . __('Energy Efficiency', 'contempo') . '</h4>';
        }

        if( !empty($ct_energy_class) || !empty($ct_global_energy_performance_index) || !empty($ct_renewable_energy_performance_index) || !empty($ct_building_energy_performance) ) {
            echo '<div class="info-inner">';
                echo '<ul class="propinfo marB0 pad0">';
                    if(!empty($ct_energy_class)) {
                        echo '<li class="row energy-class"><span class="muted left">' . __('Energy Class', 'contempo') . '</span><span class="right">' . $ct_energy_class . '</span></li>';
                    }
                    if(!empty($ct_global_energy_performance_index)) {
                        echo '<li class="row global-energy-performance"><span class="muted left">' . __('Global Energy Performance', 'contempo') . '</span><span class="right">' . $ct_global_energy_performance_index . '</span></li>';
                    }
                    if(!empty($ct_renewable_energy_performance_index)) {
                        echo '<li class="row renewable-energy-performance"><span class="muted left">' . __('Renewable Energy Performance', 'contempo') . '</span><span class="right">' . $ct_renewable_energy_performance_index . '</span></li>';
                    }
                    if(!empty($ct_building_energy_performance)) {
                        echo '<li class="row building-energy-performance"><span class="muted left">' . __('Building Energy Performance', 'contempo') . '</span><span class="right">' . $ct_building_energy_performance . '</span></li>';
                    }
                echo '</ul>';
            echo '</div>';
        }

    echo '</div>';
    echo '<!-- //Energy Efficiency -->';
}

?>