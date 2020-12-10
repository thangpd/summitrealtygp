<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme WP Beauty for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/admin/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'ct_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */

if(!function_exists('ct_register_required_plugins')) {
	function ct_register_required_plugins() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			array(
				'name' 		=> __('Redux Framework', 'contempo'),
				'slug' 		=> 'redux-framework',
				'required' 	=> true,
			),

			array(
				'name'					=> __('Contempo Real Estate Custom Posts', 'contempo'),
				'slug'					=> 'contempo-real-estate-custom-posts',
				'version' 				=> '2.7.3',
				'required' 				=> true,
				'force_deactivation'	=> false,
			),

			array(
				'name' 		=> __('Elementor Page Builder', 'contempo'),
				'slug' 		=> 'elementor',
				'required' 	=> false,
			),

			array(
				'name' 		=> __('WordPress Social Login', 'contempo'),
				'slug' 		=> 'wordpress-social-login',
				'required' 	=> false,
			),

			array(
				'name' 		=> __('Booking Calendar', 'contempo'),
				'slug' 		=> 'booking',
				'required' 	=> false,
			),

			array(
				'name' 		=> __('Co-Authors Plus', 'contempo'),
				'slug' 		=> 'co-authors-plus',
				'required' 	=> false,
			),

			array(
				'name' 		=> __('Comments Ratings', 'contempo'),
				'slug' 		=> 'comments-ratings',
				'required' 	=> false,
			),

			array(
				'name' 		=> __('Contact Form 7', 'contempo'),
				'slug' 		=> 'contact-form-7',
				'required' 	=> false,
			),

			array(
				'name'     				=> __('Contempo Listing Analytics', 'contempo'), // The plugin name
				'slug'     				=> 'ct-listing-analytics', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/ct-listing-analytics.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.1.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('WP Favorite Posts', 'contempo'), // The plugin name
				'slug'     				=> 'wp-favorite-posts', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wp-favorite-posts.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '2.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('Contempo Membership & Packages', 'contempo'), // The plugin name
				'slug'     				=> 'ct-membership-packages', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/ct-membership-packages.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.3.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('Contempo Real Estate 7 Payment Gateways', 'contempo'), // The plugin name
				'slug'     				=> 'ct-real-estate-7-payment-gateways', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/ct-real-estate-7-payment-gateways.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('Contempo Mortgage Calculator Widget', 'contempo'), // The plugin name
				'slug'     				=> 'ct-mortgage-calculator', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/ct-mortgage-calculator.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '3.0.9', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('Contempo Compare Listings', 'contempo'), // The plugin name
				'slug'     				=> 'ct-compare-listings', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/ct-compare-listings.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('Contempo Saved Searches & Email Alerts', 'contempo'), // The plugin name
				'slug'     				=> 'contempo-saved-searches-email-alerts', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempo-saved-searches-email-alerts.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('Contempo Child Theme Generator', 'contempo'), // The plugin name
				'slug'     				=> 'ct-child-theme', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/ct-child-theme.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('Slider Revolution', 'contempo'), // The plugin name
				'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/revslider.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '6.2.22', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> __('WPBakery Page Builder', 'contempo'), // The plugin name
				'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/js_composer.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '6.3.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			
			array(
				'name'     				=> __('Envato Market', 'contempo'), // The plugin name
				'slug'     				=> 'envato-market', // The plugin slug (typically the folder name)
				'source'   				=> 'https://s3-us-west-2.amazonaws.com/re7-demo-files/envato-market.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '2.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'realestate-7',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.

			/*
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'contempo' ),
				'menu_title'                      => __( 'Install Plugins', 'contempo' ),
				/* translators: %s: plugin name. * /
				'installing'                      => __( 'Installing Plugin: %s', 'contempo' ),
				/* translators: %s: plugin name. * /
				'updating'                        => __( 'Updating Plugin: %s', 'contempo' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'contempo' ),
				'notice_can_install_required'     => _n_noop(
					/* translators: 1: plugin name(s). * /
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'contempo'
				),
				'notice_can_install_recommended'  => _n_noop(
					/* translators: 1: plugin name(s). * /
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'contempo'
				),
				'notice_ask_to_update'            => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'contempo'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					/* translators: 1: plugin name(s). * /
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'contempo'
				),
				'notice_can_activate_required'    => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'contempo'
				),
				'notice_can_activate_recommended' => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'contempo'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'contempo'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'contempo'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'contempo'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'contempo' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'contempo' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'contempo' ),
				/* translators: 1: plugin name. * /
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'contempo' ),
				/* translators: 1: plugin name. * /
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'contempo' ),
				/* translators: 1: dashboard link. * /
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'contempo' ),
				'dismiss'                         => __( 'Dismiss this notice', 'contempo' ),
				'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'contempo' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'contempo' ),

				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			),
			*/
		);

		tgmpa( $plugins, $config );
	}
}

add_action( 'vc_before_init', 'ct_vcSetAsTheme' );
function ct_vcSetAsTheme() {
    vc_set_as_theme();
}