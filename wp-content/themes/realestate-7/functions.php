<?php
/**
 * Functions
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

/*-----------------------------------------------------------------------------------*/
/* Define some constant paths */
/*-----------------------------------------------------------------------------------*/

define('ADMIN_PATH', get_template_directory() . '/admin/');
define('INC_PATH', get_template_directory() . '/includes/');

/*-----------------------------------------------------------------------------------*/
/* Load ReduxFramework Options */
/*-----------------------------------------------------------------------------------*/

require_once(ADMIN_PATH . 'ReduxFramework/theme-options/re7-config.php');

/*-----------------------------------------------------------------------------------*/
/* Localization Support */
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain('contempo', get_template_directory() . '/languages');
 
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";

if (is_readable($locale_file)) {
    require_once($locale_file);
}

/*-----------------------------------------------------------------------------------*/
/* Framework Functions
/*-----------------------------------------------------------------------------------*/

// Getting Started 
require_once (ADMIN_PATH . 'getting-started/getting-started.php');
define( 'REALESTATE7_SL_THEME_VERSION', wp_get_theme( 'realestate-7' )->get( 'Version' ) );

$ct_geting_started = new ct_getting_started_admin(

	// Config settings
	$config = array(
		'item_name'      => 'WP Pro Real Estate 7 WordPress Theme', // Name of theme
		'theme_slug'     => 'realestate-7', // Theme slug
		'version'        => REALESTATE7_SL_THEME_VERSION, // The current version of this theme
		'author'         => 'Contempo', // The author of this theme
	),

	// Strings
	$strings = array(
		'getting-started'           => __( 'Getting Started', 'contempo' ),
	)

);

// OAuth
if(!class_exists('OAuthToken')) {
	require_once (ADMIN_PATH . 'OAuth.php');
}

// Google Places
require_once (ADMIN_PATH . 'google-places/GooglePlaces.php');
require_once (ADMIN_PATH . 'google-places/GooglePlacesClient.php');

// Custom Profile Fields
require_once (ADMIN_PATH . 'profile-fields.php');

// Plugin Activation
require_once (ADMIN_PATH . 'plugins/class-tgm-plugin-activation.php');
require_once (ADMIN_PATH . 'plugins/register.php');

// Merlin
require_once (ADMIN_PATH . 'merlin/vendor/autoload.php' );
require_once (ADMIN_PATH . 'merlin/class-merlin.php' );
require_once (ADMIN_PATH . 'merlin-config.php' );

// Theme Functions
require_once (ADMIN_PATH . 'theme-functions.php');

//query
require_once (ADMIN_PATH.'function_request_query.php');

// Theme Hooks
require_once (ADMIN_PATH . 'theme-hooks.php');

// CT Social Widget
require_once (ADMIN_PATH . 'ct-social/ct-social.php');

// Register Sidebars
require_once (ADMIN_PATH . 'sidebars.php');

// Widgets
require_once (INC_PATH . 'widgets.php');

add_filter("wpcf7_posted_data", function ($wpcf7_posted_data) {

    $post = get_post($wpcf7_posted_data["_wpcf7_container_post"]);

    $wpcf7_posted_data["containerURL"] = get_permalink($post);


    return $wpcf7_posted_data;

});


