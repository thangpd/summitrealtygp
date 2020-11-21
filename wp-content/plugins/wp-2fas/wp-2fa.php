<?php // phpcs:ignore
/**
 * Plugin Name: WP 2FA - Two-factor authentication for WordPress

 * Plugin URI:  https://www.wpwhitesecurity.com
 * Description: Easily add an additional layer of security to your WordPress login pages. Enable Two-Factor Authentication for you and all your website users with this easy to use plugin.
 * Version:     1.4.2
 * Author:      WP White Security
 * Author URI:  https://www.wpwhitesecurity.com
 * Text Domain: wp-2fa
 * Domain Path: /languages
 * Network:     true
 * @package WP2FA
 */

// Useful global constants.
define( 'WP_2FA_VERSION', '1.4.2' );
define( 'WP_2FA_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_2FA_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_2FA_INC', WP_2FA_PATH . 'includes/' );
define( 'WP_2FA_FILE', __FILE__ );
define( 'WP_2FA_BASE', plugin_basename( __FILE__ ) );


// Include files.
require_once WP_2FA_INC . 'functions/core.php';

// Require Composer autoloader if it exists.
if ( file_exists( WP_2FA_PATH . '/vendor/autoload.php' ) ) {
	require_once WP_2FA_PATH . 'vendor/autoload.php';
}

$wp2fa = \WP2FA\WP2FA::get_instance();
$wp2fa->init();
