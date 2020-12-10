<?php
/**
 * Merlin WP configuration file.
 *
 * @package @@pkg.name
 * @version @@pkg.version
 * @author  @@pkg.author
 * @license @@pkg.license
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and other settings for Merlin WP.
 */
$wizard = new Merlin(
	// Configure Merlin with custom settings.
	$config = array(
		'directory'					=> 'admin/merlin', // Location where the 'merlin' directory is placed.
		'merlin_url'				=> 'merlin', // Customize the page URL where Merlin WP loads.
		'child_action_btn_url'		=> 'http://contempothemes.com/wp-real-estate-7/documentation/#childthemes',  // The URL for the 'child-action-link'.
		'dev_mode'					=> false, // Enable development mode for testing.
		'license_step'       		=> false, // EDD license activation step.
		'license_help_url'			=> '',
		'license_required'     		=> false, // Require the license activation step.
		'license_help_url'     		=> '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   		=> '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        		=> '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       		=> '', // EDD_Theme_Updater_Admin item_slug.
	),
	// Text strings.
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup' , '@@textdomain' ),
		'title%s%s%s%s' 		   => esc_html__( '%s%s Themes &lsaquo; Theme Setup: %s%s' , '@@textdomain' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard' , '@@textdomain' ),
		'ignore'                   => esc_html__( 'Disable this wizard', '@@textdomain' ),

		'btn-skip'                 => esc_html__( 'Skip' , '@@textdomain' ),
		'btn-next'                 => esc_html__( 'Next' , '@@textdomain' ),
		'btn-start'                => esc_html__( 'Start' , '@@textdomain' ),
		'btn-no'                   => esc_html__( 'Cancel' , '@@textdomain' ),
		'btn-plugins-install'      => esc_html__( 'Install' , '@@textdomain' ),
		'btn-child-install'        => esc_html__( 'Install' , '@@textdomain' ),
		'btn-content-install'      => esc_html__( 'Install' , '@@textdomain' ),
		'btn-import'               => esc_html__( 'Import' , '@@textdomain' ),

		'welcome-header%s'         => esc_html__( 'Welcome to %s' , '@@textdomain' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back' , '@@textdomain' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.' , '@@textdomain' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.' , '@@textdomain' ),

		'child-header'             => esc_html__( 'Install Child Theme' , '@@textdomain' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!' , '@@textdomain' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.' , '@@textdomain' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.' , '@@textdomain' ),
		'child-action-link'        => esc_html__( 'Learn about child themes' , '@@textdomain' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.' , '@@textdomain' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.' , '@@textdomain' ),

		'plugins-header'           => esc_html__( 'Install Plugins' , '@@textdomain' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!' , '@@textdomain' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.' , '@@textdomain' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.' , '@@textdomain' ),
		'plugins-action-link'      => esc_html__( 'Advanced' , '@@textdomain' ),

		'import-header'            => esc_html__( 'Import Content' , '@@textdomain' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme. Keep in mind this could take a little bit depending on your server setup, so let it run and do its thing.' , '@@textdomain' ),
		'import-action-link'       => esc_html__( 'Advanced' , '@@textdomain' ),

		'ready-header'             => esc_html__( 'All done. Have fun!' , '@@textdomain' ),
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.' , '@@textdomain' ),
		'ready-action-link'        => esc_html__( 'Extras' , '@@textdomain' ),
		'ready-big-button'         => esc_html__( 'View your website' , '@@textdomain' ),

		'ready-link-1'             => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__( 'Explore WordPress', '@@textdomain' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
		'ready-link-2'             => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'http://contempothemes.com/wp-real-estate-7/documentation/', esc_html__( 'Get Theme Support', '@@textdomain' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
		'ready-link-3'             => wp_kses( sprintf( '<a href="'.admin_url( 'admin.php?page=WPProRealEstate7Child&tab=1' ).'">%s</a>', esc_html__( 'Start Customizing', '@@textdomain' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
	)
);

/**
 * Define the demo import files (remote files).
 *
 * To define imports, you just have to add the following code structure,
 * with your own values to your theme (using the 'merlin_import_files' filter).
 */
function merlin_import_files() {
	return array(
		array(
			'import_file_name'           => 'Elementor Demo 1',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.elementor.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			//'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-realestate.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_elementor_demo_1.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'https://contempothemes.com/wp-real-estate-7/elementor-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/elementor-1-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/elementor-demo',
		),
		array(
			'import_file_name'           => 'Elementor Demo 2',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/elementor-two-demo-content.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-elementor-two-demo-widgets.json',
			//'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-realestate.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux-options-elementor-two-demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'https://contempothemes.com/wp-real-estate-7/elementor-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/elementor-2-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/elementor-two-demo',
		),
		array(
			'import_file_name'           => 'Elementor Demo 3',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/elementor-three-demo-content.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-elementor-three-demo-widgets.json',
			//'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-realestate.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux-options-elementor-three-demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'https://contempothemes.com/wp-real-estate-7/elementor-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/elementor-3-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/elementor-three-demo',
		),
		array(
			'import_file_name'           => 'Elementor Demo 4',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/elementor-demo-4-content.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-elementor-three-demo-widgets.json',
			//'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-realestate.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/elementor-demo-4-options.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'https://contempothemes.com/wp-real-estate-7/elementor-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/elementor-4-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/elementor-four-demo',
		),
		array(
			'import_file_name'           => 'Elementor Demo 5',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/elementor-five-demo-content.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/elementor-five-demo-widgets.wie',
			//'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-realestate.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/elementor-five-demo-admin-options.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'https://contempothemes.com/wp-real-estate-7/elementor-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/elementor-5-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/elementor-five-demo',
		),
		array(
			'import_file_name'           => 'Multi Demo 1',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-hero.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_minimal.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/multi-slider-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/minimal-demo',
		),
		array(
			'import_file_name'           => 'Multi Demo 2',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-realestate.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_multi_demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/multi-slider-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-demo',
		),
		array(
			'import_file_name'           => 'Multi Demo 3',
			'import_file_url'            => '       ',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-minimal.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_multi_three_demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/multi-header-three.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-three-demo',
		),
		array(
			'import_file_name'           => 'Multi Demo 4',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => '',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_hero_image_search.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/multi-two-hero.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-two-demo/',
		),
		array(
			'import_file_name'           => 'Multi Demo 5',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/listing-showcase.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_multi_two_demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/multi-slider-two-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-demo/home-listings-showcase/',
		),
		array(
			'import_file_name'           => 'Multi Demo 6',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => '',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_hero_video_search.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/multi-hero-video.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-demo/home-hero-video/',
		),
		array(
			'import_file_name'           => 'Multi Demo 7',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => '',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_multi_big_map.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/multi-big-map-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-demo/home-big-map/',
		),
		array(
			'import_file_name'           => 'Multi Demo 8',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => '',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_multi_demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/full-screen-parallax-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-demo/homepage-parallax/',
		),
		array(
			'import_file_name'           => 'Multi Demo 9',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => '',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_multi_demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/full-screen-agent-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-demo/agent-single-full-screen/',
		),
		array(
			'import_file_name'           => 'Multi Demo 10',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.multi-new-cloud.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-agent.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_multi_demo.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/lifestyle-agent-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/multi-demo/homepage-agent/',
		),
		array(
			'import_file_name'           => 'Vacation Rentals Demo 1',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.vacation.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/home-vacation.zip',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_vacation_rentals.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/vaca-slider-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/vacation-rentals-demo',
		),
		array(
			'import_file_name'           => 'Vacation Rentals Demo 2',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.vacation.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => '',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_vacation_rentals.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/vaca-big-map-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/vacation-rentals-demo/home-big-map/',
		),
		array(
			'import_file_name'           => 'Single Listing Demo',
			'import_file_url'            => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/wpprorealestate7.wordpress.single.xml',
			'import_widget_file_url'     => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/contempothemes.com-wp-real-estate-7-multi-demo-widgets.json',
			'import_rev_slider_file_url' => '',
			//'import_customizer_file_url' => 'http://www.your_domain.com/merlin/customizer2.dat',
			'import_redux'               => array(
				array(
					'file_url'    => 'https://s3-us-west-2.amazonaws.com/re7-demo-files/redux_options_ct_options_backup_single_listing.json',
					'option_name' => 'ct_options',
				),
			),
			'import_preview_image_url'   => 'http://contempothemes.com/wp-real-estate-7/multi-demo/wp-content/plugins/aqua-style-switcher/images/screenshots/single-listing-screenshot.jpg',
			'import_notice'              => __( 'A special note for this import.', 'contempo' ),
			'preview_url'                => 'http://contempothemes.com/wp-real-estate-7/single-demo',
		),
	);
}
add_filter( 'merlin_import_files', 'merlin_import_files' );

function merlin_after_import_setup( $selected_index ) {

	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
	$footer_menu = get_term_by( 'name', 'Footer', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'primary_left' => $main_menu->term_id,
			'primary_right' => $main_menu->term_id,
			'primary_full_width' => $main_menu->term_id,
			'footer' => $footer_menu->term_id,
		)
	);

	// Assign front page to specific imports
	if ( 7 === $selected_index ) {
        $front_page_id = get_page_by_title( 'Homepage - Parallax' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
    } elseif( 8 === $selected_index ){
    	$front_page_id = get_page_by_title( 'Agent Single Full Screen' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
    } elseif( 9 === $selected_index ){
    	$front_page_id = get_page_by_title( 'Homepage - Agent' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
    } else {
    	// Assign front page "Home" for the rest of the imports
	    $front_page_id = get_page_by_title( 'Home' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
    }

}
add_action( 'merlin_after_all_import', 'merlin_after_import_setup' );

function ct_merlin_unset_default_widgets_args( $widget_areas ) {
	$widget_areas = array(
		'listings-single-right' => array(),
	);
	return $widget_areas;
}
add_filter( 'merlin_unset_default_widgets_args', 'ct_merlin_unset_default_widgets_args' );
