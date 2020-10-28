<?php

/**
 *
 * Plugin Name:       Contempo Saved Searches & Email Alerts
 * Description:       This plugin allows users be alerted via email when a listing is added.
 * Version:           1.0.6
 * Author:            Contempo
 * Author URI:        http://contempographicdesign.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ctea
 * Domain Path:       /languages
 */

/*-----------------------------------------------------------------------------------*/
/* Load Plugin Textdomain */
/*-----------------------------------------------------------------------------------*/

add_action( 'plugins_loaded', 'ctea_load_textdomain' );

function ctea_load_textdomain() {
  load_plugin_textdomain( 'ctea', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

/*-----------------------------------------------------------------------------------*/
/* Create Alert Shortcode */
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'ctea_alert_creation', 'ctea_show_alert_creation' );

function ctea_show_alert_creation() {
	global $current_user;
	wp_get_current_user();

?>
<form method="post" action="" class="ctea-alert-creation-form">
	<section class="col span_12 create-alert marB60">

		<h3 class="marT0 marB5"><?php _e('Create a new email alert', 'ctea'); ?></h3>
		<p class="muted"><?php _e('What are you looking for? Fill out the fields below it can be as precise or as broad as you like.', 'ctea'); ?></p>

		<div id="property_type" class="col span_3 first">
			<label><?php esc_html_e('Type of Property', 'ctea'); ?></label>
			<?php ct_submit_listing_form_select('property_type'); ?>
		</div>

		<div id="status" class="col span_3">
			<label><?php esc_html_e('Status', 'ctea'); ?></label>
			<?php ct_submit_listing_form_select('ct_status'); ?>
		</div>

		<div class="col span_3">
			<label><?php esc_html_e('Beds', 'ctea'); ?></label>
			<input type="text" name="beds" id="beds" value="" placeholder="<?php _e('Number of Beds', 'ctea'); ?>" />
		</div>

		<div class="col span_3">
			<label><?php esc_html_e('Baths', 'ctea'); ?></label>
			<input type="text" name="baths" id="baths" value="" placeholder="<?php _e('Number of Baths', 'ctea'); ?>" />
		</div>

		<div class="col span_3 first">
			<label><?php esc_html_e('Price From', 'ctea'); ?> (<?php ct_currency(); ?>)</label>
			<input type="text" name="pricefrom" id="pricefrom" value="" placeholder="<?php esc_html_e('', 'ctea'); ?>" />
		</div>

		<div class="col span_3">
			<label><?php esc_html_e('Price To', 'ctea'); ?> (<?php ct_currency(); ?>)</label>
			<input type="text" name="priceto" id="priceto" value="" placeholder="<?php esc_html_e('', 'ctea'); ?>" />
		</div>

		<div id="city_code" class="col span_3">
			<label><?php esc_html_e('City', 'ctea'); ?></label>
			<?php ct_search_form_select('city'); ?>
		</div>

		<div id="state_code" class="col span_3">
			<label><?php esc_html_e('State', 'ctea'); ?></label>
			<?php ct_search_form_select('state'); ?>
		</div>

            <div class="clear"></div>

		<div class="col span_3 first">
			<label><?php ct_zip_or_post(); ?></label>
			<input type="text" name="zip" id="zip" value="" placeholder="" />
		</div>

		 <div class="col span_3 submit">
			<label><?php esc_html_e('Submit', 'ctea'); ?></label>
			<a tabindex="5" id="ct-alert-creation" class="btn save-btn"><?php esc_html_e('Submit Alert', 'ctea'); ?></a>
		</div>
	<input type="hidden" name="ctea_alert_creation_nounce" value="<?php echo wp_create_nonce('ctea-alert-creation-nounce')?>">
	<input type="hidden" name="action" value="ct_alert_creation_save">
	<input type="hidden" name="ctea_email" id="ctea_email_address" value="<?php echo $current_user->user_email; ?>" />
	</section>
	
</form>

<hr />
<?php
}

add_action('wp_enqueue_scripts','cp_enqueue_scripts');
function cp_enqueue_scripts(){
	global $current_user;
	wp_get_current_user();
	wp_enqueue_script('save-search',plugins_url('js/save-remove-search.js',__FILE__),array('jquery'),'1.6.4', true );
	$user_array = array(
		'userID' => $current_user->ID,
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'process_loader_spinner' => 'fa fa-spin fa-spinner',
		'confirm' => esc_html__('Are you sure you want to delete?', 'ctea'),
		);
wp_localize_script('save-search', 'UserInfo', $user_array);		
	
}
/*-----------------------------------------------------------------------------------*/
/*     Searched Save Search
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_ct_email_cron_onoff', 'ct_email_cron_onoff' );
if( !function_exists('ct_email_cron_onoff') ) {
    function ct_email_cron_onoff() {

        global $wpdb, $current_user;
		$all = $_POST['id'];
        wp_get_current_user();
        $propid       = $_POST['id'];
		$esetting 	  = $_REQUEST['esetting'];
		$authorid 	  = $_REQUEST['author_id'];
        $table_name   = $wpdb->prefix . 'ct_search';

		$update_esetting = array( 'esetting' => $esetting );
		$where = array( 'id' => $propid );
        $wpdb->update(
            $table_name,
			$update_esetting,
			$where
			);
			
        echo json_encode( array( 'success' => true, 'msg' => esc_html__(' - Esetting is saved. You will receive an email notification when new properties matching your search will be published', 'ctea'), 'in' => $all ) );
        wp_die();
    }
}

/*-----------------------------------------------------------------------------------*/
/*     Searched Save Search
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_ct_searched_save_search', 'ct_searched_save_search' );
if( !function_exists('ct_searched_save_search') ) {
    function ct_searched_save_search() {

        $nonce = $_REQUEST['ct_searched_save_search_ajax'];
        if( !wp_verify_nonce( $nonce, 'ct-searched-save-search-nounce' ) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__( 'Unverified Nonce!', 'ctea')
            ));
            wp_die();
        }

        global $wpdb, $current_user;

        wp_get_current_user();
        $userID       =  $current_user->ID;
        $userEmail    =  $current_user->user_email;
        $search_args  =  $_POST['search_args'];
        $table_name   = $wpdb->prefix . 'ct_search';
        $request_url  = $_REQUEST['search_URI'];

        $wpdb->insert(
            $table_name,
            array(
                'auther_id' => $userID,
                'query'     => $search_args,
                'email'     => $userEmail,
                'url'       => $request_url,
				'esetting'  => 'on',
                'time'      => current_time( 'mysql' )
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
				'%s',
                '%s'
            )
        );

        echo json_encode( array( 'success' => true, 'msg' => esc_html__('Search is saved. You will receive an email notification when new properties matching your search will be published', 'ctea') ) );
        wp_die();
    }
}
/*-----------------------------------------------------------------------------------*/
/*     Alert Creation Search
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_ct_alert_creation_save', 'ct_alert_creation_save' );
if( !function_exists('ct_alert_creation_save') ) {
    function ct_alert_creation_save() {

        $nonce = $_REQUEST['ctea_alert_creation_nounce'];
        if( !wp_verify_nonce( $nonce, 'ctea-alert-creation-nounce' ) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__( 'Unverified Nonce!', 'ctea')
            ));
            wp_die();
        }

        global $wpdb, $current_user;

        wp_get_current_user();
		$propery_type = $_REQUEST['ct_property_type'];
		$posted_args = array(
			'property_type' => $_REQUEST['ct_property_type'],
			'status' => $_REQUEST['ct_ct_status'],
			'beds' => $_REQUEST['beds'],
			'baths' => $_REQUEST['baths'],
			'pricefrom' => $_REQUEST['pricefrom'],
			'priceto' => $_REQUEST['priceto'],
			'city' => $_REQUEST['ct_city'],
			'state' => $_REQUEST['ct_state'],
			'zip' => $_REQUEST['zip'],
		);
		$coded_args = base64_encode(serialize($posted_args));
        $userID       =  $current_user->ID;
        $userEmail    =  $current_user->user_email;
        $search_args  =  $coded_args;
        $table_name   = $wpdb->prefix . 'ct_search';
        $request_url  = 'email-alerts';

        $wpdb->insert(
            $table_name,
            array(
                'auther_id' => $userID,
                'query'     => $search_args,
                'email'     => $userEmail,
                'url'       => $request_url,
				'esetting'  => 'on',
                'time'      => current_time( 'mysql' )
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
				'%s',
                '%s'
            )
        );

        echo json_encode( array( 'success' => true, 'msg' => esc_html__('Alert has been saved. You will receive an email notification when new properties matching your search will be published', 'ctea') ) );
        wp_die();
    }
}
/*-----------------------------------------------------------------------------------*/
/*     Remove Search
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_ct_delete_search', 'ct_delete_search');
if(!function_exists('ct_delete_search') ) {
    function ct_delete_search () {
        global $current_user;
        wp_get_current_user();
        $userID = $current_user->ID;

        $property_id = intval( $_POST['property_id']);

        if( !is_numeric( $property_id ) ){
            echo json_encode( array(
                'success' => false,
                'msg' => esc_html__('you don\'t have the right to delete this', 'ctea')
            ));
            wp_die();
        }else{

            global $wpdb;

            $table_name     = $wpdb->prefix . 'ct_search';
            $results        = $wpdb->get_row( 'SELECT * FROM ' . $table_name . ' WHERE id = ' . $property_id );
            if ( $userID != $results->auther_id ) :

                echo json_encode( array(
                    'success' => false,
                    'msg' => esc_html__('you don\'t have the right to delete this', 'ctea')
                ));

                wp_die();

            else :

                $wpdb->delete( $table_name, array( 'id' => $property_id ), array( '%d' ) );

                echo json_encode( array(
                    'success' => true,
                    'msg' => esc_html__('Deleted Successfully', 'ctea')
                ));

                wp_die();

            endif;
        }
    }
}
// Property Taxonomy
if(!function_exists('ct_get_property_type_name') ) {
	function ct_get_property_type_name( $slug ){
		$term_slug = get_term_by('slug', $slug, 'property_type');
        if(!empty($term_slug)) {
    		$name = $term_slug->name;
    		return $name;
        }
	}
}
// Status Taxonomy
if(!function_exists('ct_get_status_name') ) {
	function ct_get_status_name( $slug ){
		$term_slug = get_term_by('slug', $slug, 'ct_status');
		if(!empty($term_slug)) {
            $name = $term_slug->name;
            return $name;
        }
	}
}
// City Taxonomy
if(!function_exists('ct_get_city_name') ) {
	function ct_get_city_name( $slug ){
		$term_slug = get_term_by('slug', $slug, 'city');
		if(!empty($term_slug)) {
            $name = $term_slug->name;
            return $name;
        }
	}
}
// State Taxonomy
if(!function_exists('ct_get_state_name') ) {
	function ct_get_state_name( $slug ){
		$term_slug = get_term_by('slug', $slug, 'state');
		if(!empty($term_slug)) {
            $name = $term_slug->name;
            return $name;
        }
	}
}
// Country Taxonomy
if(!function_exists('ct_get_country_name') ) {
	function ct_get_country_name( $slug ){
		$term_slug = get_term_by('slug', $slug, 'country');
		if(!empty($term_slug)) {
            $name = $term_slug->name;
            return $name;
        }
	}
}
// Community Taxonomy
if(!function_exists('ct_get_community_name') ) {
	function ct_get_community_name( $slug ){
		$term_slug = get_term_by('slug', $slug, 'community');
		if(!empty($term_slug)) {
            $name = $term_slug->name;
            return $name;
        }
	}
}
function ctea_plugin_activate() {

    global $wpdb;

        $table_name         = $wpdb->prefix . 'ct_search';
        $charset_collate    = $wpdb->get_charset_collate();
        $sql                = "CREATE TABLE $table_name (
           id mediumint(9) NOT NULL AUTO_INCREMENT,
           auther_id mediumint(9) NOT NULL,
           query longtext NOT NULL,
           email longtext NOT NULL,
           url longtext NOT NULL,
		   esetting text NOT NULL,
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           UNIQUE KEY id (id)
       ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );
}
register_activation_hook( __FILE__, 'ctea_plugin_activate' );

function ctea_setup_schedule_email_alerts() {
    ctea_schedule_email_alerts();
}
add_action( 'wp', 'ctea_setup_schedule_email_alerts' );


add_filter( 'cron_schedules', 'ctea_add_cron_schedule' );
function ctea_add_cron_schedule( $schedules ) {

        $schedules['weekly'] = array(
            'interval' => 7 * 24 * 60 * 60, //7 days * 24 hours * 60 minutes * 60 seconds
            'display'  => 'Once Weekly',
        );

		$schedules['one_minute'] = array(
            'interval' => 30,
            'display'  => 'One minute',
		);
		
        return $schedules;
}

function ctea_schedule_email_alerts(){
	global $ct_options;
	$email_alerts_page = isset($ct_options['ct_listing_email_alerts_page_id']) ? $ct_options['ct_listing_email_alerts_page_id'] : '' ;

    $interval = $ct_options['ct_listing_email_alerts_interval'];

    if( $email_alerts_page != '' ) {
        if( $interval === 'daily' ) {
            if (!wp_next_scheduled('ctea_run_email_alerts')) {
				wp_schedule_event(time(), 'daily', 'ctea_run_email_alerts');
			}
        } elseif( $interval === 'weekly' ) {
            if (!wp_next_scheduled('ctea_run_email_alerts')) {
				wp_schedule_event(time(), 'weekly', 'ctea_run_email_alerts');
			}
        } elseif( $interval === 'hourly' ) {
			if (!wp_next_scheduled('ctea_run_email_alerts')) {
				wp_schedule_event(time(), 'hourly', 'ctea_run_email_alerts');
			}
		}

    } else {
        wp_clear_scheduled_hook('ctea_run_email_alerts');
    }

}
// our action for cron -- hook
add_action('ctea_run_email_alerts', 'ctea_get_new_listings');

if( !function_exists('ctea_get_new_listings') ) {
    function ctea_get_new_listings() {

        $wp_date_query = ctea_date_query();
        $args = array(
            'post_type' => 'listings',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy'  => 'ct_status',
                    'field'     => 'slug',
                    'terms'     => 'sold',
                    'operator'  => 'NOT IN'
                )
            ),
            'date_query' => $wp_date_query
        );
        $listings = new WP_Query($args);

        if ($listings->have_posts()) {
            ctea_get_saved_email_alerts();
        }
    }
}

/*-----------------------------------------------------------------------------------*/
// Check saved searches
/*-----------------------------------------------------------------------------------*/
function ctea_get_saved_email_alerts() {
        global $wpdb;

        $table_name     = $wpdb->prefix . 'ct_search';
        $saved_alerts   = $wpdb->get_results( 'SELECT * FROM ' . $table_name, OBJECT );

        if ( sizeof ( $saved_alerts ) !== 0 ) :

            foreach ( $saved_alerts as $saved_alert ) :
				
				if ( $saved_alert->esetting != 'off') {
                // $post_id = get_the_id();
                $arguments = unserialize( base64_decode( $saved_alert->query ) );

                $user_email = $saved_alert->email;

                $mail_content = ctea_fireup_email($arguments);
				
				$subject = __('Alert! New Listings Matching your Criteria.', 'ctea');
				
					if ($user_email != '' && $mail_content != '') :

						ctea_ship_email( $user_email, $subject, $mail_content );

					endif;
				}

            endforeach;

        endif;

}
function ctea_ship_email( $user_email, $subject, $mail_content ){
    global $ct_options;

    $site_title = get_bloginfo('name');

    $ct_logo = isset( $ct_options['ct_logo']['url'] ) ? esc_html( $ct_options['ct_logo']['url'] ) : '';
    $ct_logo_highres = isset( $ct_options['ct_logo_highres']['url'] ) ? esc_html( $ct_options['ct_logo_highres']['url'] ) : '';
    $ct_email_alerts_page = isset($ct_options['ct_listing_email_alerts_page_id']) ? $ct_options['ct_listing_email_alerts_page_id'] : '' ;
    $ct_email_alerts_header_content = isset($ct_options['ct_email_alerts_header_content']) ? $ct_options['ct_email_alerts_header_content'] : '' ;
    $ct_email_alerts_footer_content = isset($ct_options['ct_email_alerts_footer_content']) ? $ct_options['ct_email_alerts_footer_content'] : '' ;
    $ct_email_alerts_footer_company_info = isset($ct_options['ct_email_alerts_footer_company_info']) ? $ct_options['ct_email_alerts_footer_company_info'] : '' ;   
   
    $headers = 'From: ' . $site_title . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>' . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if(!empty($ct_options['ct_logo']['url'])) {
        $email_content = '<div style="margin: 0 auto; text-align: center; max-width: 70%; background-color:#ffff; padding: 16px 0;">
                            <a href="'. esc_url(home_url()) . '"><img style="max-width: 50%; margin: 0 auto;" class="logo left" src="' . esc_url($ct_logo) . '" srcset="' . esc_url($ct_logo_highres) . ' 2x" /></a>
                        </div>';
    }

    if(!empty($ct_email_alerts_header_content)) {
        $email_content .= '<div style="padding-top: 30px; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                        <div style="width: 640px; background-color:#ffff; margin: 0 auto;">
                            ' . $ct_email_alerts_header_content . '
                        </div>
                    </div>';
    }

    $email_content .= '<div style="background-color: #F6F6F6; padding: 30px;">
                        <div style="margin: 0 auto; width: 620px; background-color: #fff;border:1px solid #eee; padding:30px;">
                            <div style="font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;font-size:100%;line-height:1.6em;display:block;max-width:600px;margin:0 auto;padding:0">
                                ' . $mail_content . '
                            </div>
                        </div>
                    </div>';

    if(!empty($ct_email_alerts_footer_content)) {
        $email_content .= '<div style="padding-top: 30px; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                        <div style="width: 640px; background-color:#ffff; margin: 0 auto;">
                            ' . $ct_email_alerts_footer_content . '
                        </div>
                    </div>';
    }

    $email_content .= '<div style="padding-top: 30px; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                    <div style="width: 640px; background-color:#ffff; margin: 0 auto; text-align: center;">
                        ' . __('If you do not wish to be notified anymore please enter your account and delete the alert.', 'ctea') . '<br />'
                        . __('Manage your email alerts', 'ctea') . ' <a href="' . get_page_link($ct_email_alerts_page) . '">' . __('here', 'ctea') . '</a>
                    </div>
                </div>';

    if(!empty($ct_email_alerts_footer_company_info)) {
        $email_content .= '<div style="padding-top: 30px; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                        <div style="width: 640px; background-color:#ffff; margin: 0 auto;">
                            ' . $ct_email_alerts_footer_company_info . '
                        </div>
                    </div>';
    }

    $email_messages = $email_content;


    @wp_mail(
        $user_email,
        $subject,
        $email_messages,
        $headers
    );
}

function ctea_date_query() {
        global $ct_options;
        $interval = $ct_options['ct_listing_email_alerts_interval'];

        if ( $interval === 'daily' ) {
            $today = getdate();
            $wp_date_query = array(
                array(
                    'year' => $today['year'],
                    'month' => $today['mon'],
                    'day' => $today['mday'],
                )
            );
        } elseif ( $interval === 'weekly' ) {
            $wp_date_query = array(
                array(
                    'year' => date('Y'),
                    'week' => date('W'),
                )
            );
        } elseif ( $interval === 'hourly' ) {
			$wp_date_query = array(
                array(
                    'year' => $today['year'],
                    'month' => $today['mon'],
                    'day' => $today['mday'],
					'hour' => $today['hours'],
                )
            );
		}
        return $wp_date_query;
}

function ctea_fireup_email($args){

        global $ct_options;
        
        $mail_content   = '';
        $mail_content .= '<p style="font-size: 22px; line-height: 29px; font-weight: bold; margin-bottom: 50px; text-align: center; color: #191919;">';
        $mail_content   .= esc_html__('New listings matching your chosen criteria on ', 'ctea') . $_SERVER['HTTP_HOST'];
        $mail_content .= '</p>';

        $arguments      = $args;
        $arguments['date_query'] = $date_query_array = ctea_date_query();
        //$arguments['posts_per_page'] = 1;
        $arguments['post_type'] = 'listings';

        $prop_selection = new WP_Query($arguments);

        if($prop_selection->have_posts()){

            while($prop_selection->have_posts()): $prop_selection->the_post();
               
                $post_id = get_the_id();
                $listing_title = get_the_title($post_id);
                $permaLink = get_the_permalink($post_id);

                $source = get_post_meta( $post_id, "source", true );

                $ct_bed_beds_or_bedrooms = isset( $ct_options['ct_bed_beds_or_bedrooms'] ) ? esc_html( $ct_options['ct_bed_beds_or_bedrooms'] ) : '';
                $ct_bath_baths_or_bathrooms = isset( $ct_options['ct_bath_baths_or_bathrooms'] ) ? esc_html( $ct_options['ct_bath_baths_or_bathrooms'] ) : '';

                $ct_beds_label = '';
                $ct_baths_label = '';

                if($ct_bed_beds_or_bedrooms == 'rooms') {
                    $ct_beds_label = __('Rooms', 'ctea');
                } elseif($ct_bed_beds_or_bedrooms == 'bedrooms') {
                    $ct_beds_label = __('Bedrooms', 'ctea');
                } elseif($ct_bed_beds_or_bedrooms == 'beds') {
                    $ct_beds_label = __('Beds', 'ctea');
                } else {
                    $ct_beds_label = __('Bed', 'ctea');
                }

                if($ct_bath_baths_or_bathrooms == 'bathrooms') {
                    $ct_baths_label = __('Bathrooms', 'ctea');
                } elseif($ct_bath_baths_or_bathrooms == 'baths') {
                    $ct_baths_label = __('Baths', 'ctea');
                } else {
                    $ct_baths_label = __('Bath', 'ctea');
                }

                $price = "";

                $ct_currency_placement = $ct_options['ct_currency_placement'];
                $ct_currency_decimal = isset( $ct_options['ct_currency_decimal'] ) ? esc_attr( $ct_options['ct_currency_decimal'] ) : '';
                
                $price_prefix = get_post_meta(get_the_ID(), '_ct_price_prefix', true);
                $price_postfix = get_post_meta(get_the_ID(), '_ct_price_postfix', true);

                $price_meta = get_post_meta(get_the_ID(), '_ct_price', true);
                $price_meta= preg_replace('/[\$,]/', '', $price_meta);

                if($ct_currency_placement == 'after') {
                    if(!empty($price_prefix)) {
                        $price = $price. "<span class='listing-price-prefix'>";
                        $price = $price. esc_html($price_prefix) . ' ';
                        $price = $price. '</span>';
                    }
                    if(!empty($price_meta)) {
                        $price = $price. "<span class='listing-price'>";
                        $price = $price. number_format_i18n($price_meta, $ct_currency_decimal);
                        $price = $price.ct_currency( false );
                        $price = $price. '</span>';
                    }
                    if(!empty($price_postfix)) {
                        $price = $price. "<span class='listing-price-postfix'>";
                        $price = $price.  ' ' . esc_html($price_postfix);
                        $price = $price. '</span>';
                    }
                } else {
                    if(!empty($price_prefix)) {
                        $price = $price. "<span class='listing-price-prefix'>";
                        $price = $price. esc_html($price_prefix) . ' ';
                        $price = $price. '</span>';
                    }
                    if(!empty($price_meta)) {
                        $price = $price. "<span class='listing-price'>";
                        $price = $price.ct_currency( false );
                            $price = $price. number_format_i18n($price_meta, $ct_currency_decimal);
                            $price = $price. '</span>';
                    }
                    if(!empty($price_postfix)) {
                        $price = $price. "<span class='listing-price-postfix'>";
                        $price = $price.  ' ' . esc_html($price_postfix);
                        $price = $price. '</span>';
                    }
                }
                
                if(taxonomy_exists('beds')){
                    $beds = strip_tags( get_the_term_list( $post_id, 'beds', '', ', ', '' ) );
                }
                if(taxonomy_exists('baths')){
                    $baths = strip_tags( get_the_term_list( $post_id, 'baths', '', ', ', '' ) );
                }
                if(taxonomy_exists('city')){
                    $city = strip_tags( get_the_term_list( $post_id, 'city', '', ', ', '' ) );
                }
                if(taxonomy_exists('state')){
                    $state = strip_tags( get_the_term_list( $post_id, 'state', '', ', ', '' ) );
                }
                if(taxonomy_exists('zipcode')){
                    $zipcode = strip_tags( get_the_term_list( $post_id, 'zipcode', '', ', ', '' ) );
                }

                $ct_price = get_post_meta($post_id, '_ct_price', true);
                $ct_sqft = get_post_meta($post_id, '_ct_sqft', true);

                // Mail Content
                $mail_content .= '<div style="max-width: 600px; min-width: 600px; margin-bottom: 50px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">';

                    if ( $source == "idx-api" ) {
                        
                        $imageUrl = "";
                        $images = get_post_meta( $post_id, "_ct_slider" );
                        
                        if(is_array($images[0]) && !empty($images[0])) {
                            foreach($images[0] as $key => $value) {
                                $imageUrl = $value;
                                break;
                            }
                        }

                        if($imageUrl != "") {
                            $mail_content .= '<a class="listing-featured-image"' . $permaLink . '><img style="border-radius: 3px;" width="600" src="' . $imageUrl . '" class="listings-featured-image"></a>';
                        } else {
                            $mail_content .= '<a ' .  $permaLink . '><img style="border-radius: 3px;" width="600" src="' . get_template_directory_uri() . '/images/no-image.png" srcset=" ' . get_template_directory_uri() . '/images/no-image@2x.png 2x" /></a>';  
                        }

                    } else {
                        
                        $imageFeaturedUrl = get_the_post_thumbnail_url($post_id, 'full');
                        if(!empty($imageFeaturedUrl)) {                            
                            $mail_content .= '<a ' . $permaLink . '><img style="border-radius: 3px;" width="600" src="' . $imageFeaturedUrl . '" class="listings-featured-image"></a>';
                        } else {
                            $mail_content .= '<a ' . $permaLink . '><img style="border-radius: 3px;" width="600" src="' . get_template_directory_uri() . '/images/no-image.png" srcset=" ' . get_template_directory_uri() . '/images/no-image@2x.png 2x" /></a>';
                        }

                    }

                    $mail_content .= '<div>';
                        $mail_content .= '<p style="float: left; color: #191919; font-size: 16px; text-decoration: none;">';
                            $mail_content .= '<a style="font-weight: bold; text-decoration: none; font-size: 20px; color: #191919;" href="' . $permaLink . '">';
                            $mail_content .= $listing_title;
                            $mail_content .= '</a><br />';
                            $mail_content .= $city . ', ' . $state . ' ' . $zipcode . ' ' . $country;
                        $mail_content .= '</p>';

                        $mail_content .= '<p style="float: right; font-size: 20px; text-align: right; color: #03b5c3;">';
                            $mail_content .= $price;
                        $mail_content .= '</p>'; 
                            $mail_content .= '<div style="clear: both;"></div>';
                    $mail_content .= '</div>';

                    $mail_content .= '<p style="font-size: 16px; line-height: 16px; margin: 0; color: #191919;">';
                        if(!empty($beds)) {
                            $mail_content .= '<span style="padding-right: 8px;">';
                                $mail_content .= '<span style="color: #878c92; padding-right: 2px;">' . $ct_beds_label . '</span> ' . $beds;
                            $mail_content .= '</span>';
                        }
                        if(!empty($beds) && !empty($beds)) {
                            $mail_content .= ' ';
                        }
                        if(!empty($baths)) {
                            $mail_content .= '<span style="padding-right: 8px;">';
                                $mail_content .= '<span style="color: #878c92; padding-right: 2px;">' . $ct_baths_label . '</span> ' . $baths;
                            $mail_content .= '</span>';
                        }
                        if(!empty($beds) && !empty($beds) && !empty($ct_sqft)) {
                            $mail_content .= ' ';
                        }
                        if(!empty($ct_sqft)) {
                            if($ct_options['ct_sq'] == "sqft") {
                                $mail_content .= '<span style="color: #878c92; padding-right: 2px;">' . __('Sq Ft', 'ctea') . '</span> ';
                            } else if($ct_options['ct_sq'] == "sqmeters") {
                                $mail_content .= '<span style="color: #878c92; padding-right: 2px;">' . __('m²', 'ctea') . '</span> ';
                            } else if($ct_options['ct_sq'] == "area") {
                                $mail_content .= '<span style="color: #878c92; padding-right: 2px;">' . __('Area', 'ctea') . '</span> ';
                            }
                            $mail_content .= number_format($ct_sqft, 0);
                        }
                    $mail_content .= '</p>';

                    /*$mail_content .= '<p style="color: #191919;">';
                        $mail_content .= '<strong>Link:</strong> ' . $permaLink; 
                    $mail_content .= '</p>';*/

                        $mail_content .= '<div style="clear: both;"></div>';

                $mail_content .= '</div>';

            endwhile;

        } else {
            $mail_content = '';
        }

        wp_reset_postdata();

        return $mail_content;
}