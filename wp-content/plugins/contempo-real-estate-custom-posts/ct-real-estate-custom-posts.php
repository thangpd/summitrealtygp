<?php

/**
 *
 * @link              http://contempographicdesign.com
 * @since             2.8.3
 * @package           CT_Real_Estate_Custom_Posts
 *
 * @wordpress-plugin
 * Plugin Name:       Contempo Real Estate Custom Posts
 * Plugin URI:        http://wordpress.org/contempo-real-estate-custom-posts/
 * Description:       This plugin registers listings, brokerages & testimonials custom post types, along with related custom fields & taxonomies.
 * Version:           2.8.3
 * Author:            Contempo
 * Author URI:        http://contempographicdesign.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contempo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*-----------------------------------------------------------------------------------*/
/* Load Plugin Textdomain */
/*-----------------------------------------------------------------------------------*/

add_action( 'plugins_loaded', 'ct_recp_load_textdomain' );

function ct_recp_load_textdomain() {
  load_plugin_textdomain( 'contempo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

  if(!class_exists('ctIdxPro')) { 
		// Display Notice
		function ct_idx_admin_notices() {
			global $current_user;
			$user_id = $current_user->ID;

			if(!get_user_meta($user_id, 'ct_idx_notice_dismiss')) {
				
				$ct_idx_link = 'https://contempothemes.com/wp-real-estate-7/ct-idx-pro-plugin/';

				echo '<style>';
					echo '#idx-notice-col-one { float: left; width: 22%;}';
					echo '#idx-notice-col-two { float: left; width: 74%; margin-left: 2%;;}';
						echo '#idx-notice-col-two h3 { margin-top: 30px;}';
					echo '.idx-dismiss { display: inline-block; position: relative; float: right; text-decoration: none; font-size: 12px; top: -8px; right: -24px; background: #f7f7f7; border-radius: 3px; text-align: center; padding: 4px 9px;}';
					echo '@media only screen and (min-width: 1801px) and (max-width: 2560px) {';
						echo '#idx-notice-col-one { width: 18%;}';
						echo '#idx-notice-col-two { width: 40%;}';
							echo '#idx-notice-col-two h3 { margin-top: 50px;}';
					echo '}';
					echo '@media only screen and (min-width: 1440px) and (max-width: 1800px) {';
						echo '#idx-notice-col-one { width: 24%;}';
						echo '#idx-notice-col-two { width: 72%;}';
							echo '#idx-notice-col-two h3 { margin-top: 60px;}';
					echo '}';
					echo '@media only screen and (min-width: 1024px) and (max-width: 1439px) {';
						echo '#idx-notice-col-one { width: 30%;}';
						echo '#idx-notice-col-two { width: 66%;}';
							echo '#idx-notice-col-two h3 { margin-top: 40px;}';
					echo '}';	
					echo '@media only screen and (max-width: 959px){';
						echo '#idx-notice-col-one { width: 38%;}';
						echo '#idx-notice-col-two { width: 58%;}';
					echo '}';
					echo '@media only screen and (max-width: 959px){';
						echo '#idx-notice-col-one { width: 38%;}';
						echo '#idx-notice-col-two { width: 58%;}';
					echo '}';
					echo '@media only screen and (max-width: 767px) {';
						echo '#idx-notice-col-one { width: 100%;}';
						echo '#idx-notice-col-two { width: 100%; margin-left: 0; text-align: center;}';
							echo '#idx-notice-col-two h3 { margin-top: 0;}';
					echo '}';
				echo '</style>';

				echo '<div class="updated notice is-dismissible">';
					echo '<div id="idx-notice-col-one">';
				    	echo '<img style="width: 100%;" src="https://contempo-media.s3.amazonaws.com/root/uploads/2019/10/elementor-demo-2.png" />';
				    echo '</div>';
					echo '<div id="idx-notice-col-two">';
				        echo '<h3><strong>' . __('Want to connect and display listings from your local MLS?', 'contempo') . '</strong></h3>';
				        echo '<p>' . __('Tired of confusing third-party IDX plugins that look nothing like your site? <em>We are too.</em>', 'contempo') . '</p>';
				        echo '<p style="margin-bottom: 1em;">' . __('We’ve developed an exclusive IDX plugin that directly integrates into Real Estate 7 with MLS data coverage across all 50 states, Washington D.C., and Canada. Thats 650+ MLS Markets and we’re adding more all the time.', 'contempo') . '</p>';
				        echo '<p><a class="button button-primary" href="' . esc_url($ct_idx_link) . '" target="_blank">' . __('Learn More', 'contempo') . '</a></p>';
				    echo '</div>';
				    	echo '<div class="clear"></div>';
			        echo '<a class="idx-dismiss dismiss-notice" href="' . site_url() . '/wp-admin/admin.php?ct_idx_notice_dismiss=0" target="_parent">' . __('Dismiss this notice', 'contempo') . '</a>';
			        	echo '<div class="clear"></div>';
			    echo '</div>';

			}
		}

		// Set Dismiss Referer
		function ct_idx_admin_notices_init() {
		    if ( isset($_GET['ct_idx_notice_dismiss']) && '0' == $_GET['ct_idx_notice_dismiss'] ) {
		        $user_id = get_current_user_id();
		        add_user_meta($user_id, 'ct_idx_notice_dismiss', 'true', true);
		        if (wp_get_referer()) {
		            /* Redirects user to where they were before */
		            wp_safe_redirect(wp_get_referer());
		        } else {
		            /* if there is no referrer you redirect to home */
		            wp_safe_redirect(home_url());
		        }
		    }
		}
		
		add_action('admin_init', 'ct_idx_admin_notices_init');
		add_action( 'admin_notices', 'ct_idx_admin_notices' );
	}
}

/*-----------------------------------------------------------------------------------*/
/* Load Metaboxes, CPT, Shortcodes, Taxonomies */
/*-----------------------------------------------------------------------------------*/

$theme = wp_get_theme(); // gets the current theme
if ($theme->name != 'WP Pro Real Estate 6' && $theme->name != 'WP Pro Real Estate 5') {

	/*-----------------------------------------------------------------------------------*/
	/* Load ReduxFramework */
	/*-----------------------------------------------------------------------------------*/

	require plugin_dir_path( __FILE__ ) . 'ct-real-estate-cmb2-functions.php';
	
	if ( ! function_exists( 'ct_metaboxes' ) ) {
		require plugin_dir_path( __FILE__ ) . 'includes/metabox/metaboxes.php';
	}

	//require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-functions.php';
	require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-post-types.php';
	require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-shortcodes.php';
	require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-taxonomies.php';
	//require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-widgets.php';
	//require plugin_dir_path( __FILE__ ) . 'includes/class-ct-real-estate-custom-posts-i18n.php';

	// Only load CT Elementor Widets if plugin has been activated
	if ( ! did_action( 'elementor/loaded' ) ) {
		require plugin_dir_path( __FILE__ ) . 'ct-elementor-widgets/ct-elementor-widgets.php';
	}

} else {

	function ct_admin_notices() {
		global $current_user;
		$user_id = $current_user->ID;
		
		if ( ! get_user_meta($user_id, 'ct_install_nag_ignore') ) {
			echo '<div class="updated notice is-dismissible">';
		        _e('<h3><strong>You currently have the incorrect real estate custom posts plugin installed/activated!</strong></h3>', 'contempo');
		        echo '<ol>';
			        echo '<li>You need to Deactivate and Delete <a href="' . site_url() . '/wp-admin/plugins.php">Contempo Real Estate Custom Posts</a>.';
			        echo '<li>Then Install and Activate <a href="' .site_url() . '/wp-admin/themes.php?page=install-required-plugins">CT Real Estate Custom Posts</a>.</li>';
			        echo '<li>Once you\'ve done that you\'ll be good to go!</li>';
		        echo '</ol>';
	        echo '</div>';
		}
	}
	add_action( 'admin_notices', 'ct_admin_notices' );
}

if(!function_exists('get_modified_term_list_slug')) {
	function get_modified_term_list_slug( $id = 0, $taxonomy, $before = '', $sep = '', $after = '', $exclude = array() ) {
	    $terms = get_the_terms( $id, $taxonomy );

	    if ( is_wp_error( $terms ) )
	        return $terms;

	    if ( empty( $terms ) )
	        return false;

	    foreach ( $terms as $term ) {

	        if(!in_array($term->slug,$exclude)) {
	            $link = get_term_link( $term, $taxonomy );
	            if ( is_wp_error( $link ) )
	                return $link;
	            $term_links[] = $term->slug . ' ';
	        }
	    }

	    if( !isset( $term_links ) )
	        return false;

	    return $before . join( $sep, $term_links ) . $after;
	}
}

if(!function_exists('get_modified_term_list_name')) {
	function get_modified_term_list_name( $id = 0, $taxonomy, $before = '', $sep = '', $after = '', $exclude = array() ) {
	    $terms = get_the_terms( $id, $taxonomy );

	    if ( is_wp_error( $terms ) )
	        return $terms;

	    if ( empty( $terms ) )
	        return false;

	    foreach ( $terms as $term ) {

	        if(!in_array($term->slug,$exclude)) {
	            $link = get_term_link( $term, $taxonomy );
	            if ( is_wp_error( $link ) )
	                return $link;
	            $term_links[] = $term->name . ' ';
	        }
	    }

	    if( !isset( $term_links ) )
	        return false;

	    return $before . join( $sep, $term_links ) . $after;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Remove Gravatar from User Profile Admin Columns */
/*-----------------------------------------------------------------------------------*/

function ct_remove_avatar_from_users_list( $avatar ) {
    if (is_admin()) {
        global $current_screen; 
        if ( $current_screen->base == 'users' ) {
            $avatar = '';
        }
    }
    return $avatar;
}
add_filter( 'get_avatar', 'ct_remove_avatar_from_users_list' );

/*-----------------------------------------------------------------------------------*/
/* Add "Profile Image" to User Profile Admin Columns */
/*-----------------------------------------------------------------------------------*/

function ct_add_user_profile_image_column($columns) {
    $columns['profile_img'] = 'Profile Image';
    return $columns;
}
add_filter('manage_users_columns', 'ct_add_user_profile_image_column');
 
function ct_show_user_profile_image_column_content($val, $column_name, $user_id) {
    $user = get_userdata( $user_id );
    $user_profile_image = get_the_author_meta('ct_profile_url', $user_id);
    switch ($column_name) {
        case 'profile_img' :
            if(!empty($user_profile_image)) {  
                $val = '<img src="';
                    $val .= $user_profile_image;
                $val .= '" height="50" width="50" />';
            } else {
                $val = '<img src="' . get_template_directory_uri() . '/images/user-default.png' . '" height="50" width="50" />';
            }
        default:
    }
    return $val;
}
add_action('manage_users_custom_column',  'ct_show_user_profile_image_column_content', 10, 3);

?>