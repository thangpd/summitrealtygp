<?php
/**
 * Date: 10/28/20
 * Time: 10:57 PM
 */

if (!function_exists('thomas_core_set_shortcode_team_assets')) {
	/**
	 * Function that set custom icon class name for hivegallery shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function setsail_core_set_shortcode_team_assets()
	{
		wp_register_script('shortcode_team_js', plugins_url('/assets/js/modules/shortcode_team.js', __FILE__), array('jquery'), '1.0', true);
		wp_register_style('shortcode_team_css', plugins_url('/assets/css/shortcode_team.css', __FILE__), ['bootstrap']);
	}

	add_filter('init', 'setsail_core_set_shortcode_team_assets');
}