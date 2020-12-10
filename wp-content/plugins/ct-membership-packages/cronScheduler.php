<?php 
/**
 * Cron Scheduler
 *
 * @link       http://contempographicdesign.com
 * @since      1.0.0
 *
 * @package    Contempo Membership & Packages
 */

add_filter('cron_schedules', 'ct_packagesCron');
function ct_packagesCron($schedules) {
    $schedules['every_three_minutes'] = array(
            'interval'  => 86400,
            'display'   => __('Every 3 Minutes', 'ct-membership-packages')
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if(!wp_next_scheduled( 'ct_packagesCron')) {
    wp_schedule_event( time(), 'every_three_minutes', 'ct_packagesCron' );
}

// Hook into that action that'll fire every three minutes
add_action('ct_packagesCron', 'ct_packagesCronOrder');
function ct_packagesCronOrder() {

	global $ct_options;

    $ct_logo = isset( $ct_options['ct_logo']['url'] ) ? esc_html( $ct_options['ct_logo']['url'] ) : '';
    $ct_logo_highres = isset( $ct_options['ct_logo_highres']['url'] ) ? esc_html( $ct_options['ct_logo_highres']['url'] ) : '';

	$packages_orders = get_posts( array(
		'post_type' => 'package_order',
		'posts_per_page' => -1,
		'order' =>'asc'					
	));
			
	$orderMeta = 	array();
	$i=0;

	foreach($packages_orders as $packorder) {
			$orderMeta[$i]['ID'] = 	$packorder->ID;				
			$orderMeta[$i]['post_title'] = $packorder->post_title;			
			$orderMeta[$i]['package_expire_date'] = get_post_meta( $packorder->ID, 'package_expire_date',true);	
			$orderMeta[$i]['current_user_email'] = get_post_meta( $packorder->ID, 'current_user_email',true);	
		$i++;				 
	}
	//echo '<pre>';print_r($orderMeta);die;
	$today_date = strtotime(date('Y-m-d')); 
	$admin_email = get_option('admin_email');
	 
	foreach($orderMeta as $interval){										 
		//$intervalTime = strtotime($interval['package_expire_date']);	
		$orderID = $interval['ID'];	
		$packageName = $interval['post_title'];	
		$packageExpiredate = $interval['package_expire_date'];	
		$usermail = $interval['current_user_email'];	
		$days_ago = strtotime(date('Y-m-d', strtotime('-2 days', strtotime($interval['package_expire_date']))));  
		//$days_ago = date('Y-m-d', strtotime('-2 days', strtotime($intervalTime)));			

		if($today_date == strtotime($packageExpiredate)){
			update_post_meta($orderID,'order_status',0); 
		}
			if($today_date == $days_ago){
				$to = $admin_email;				
				$subject = __('Package Order Expire Notification from ', 'ct-membership-packages') . ' ' . $_SERVER['HTTP_HOST'];
			
				$body = '<table border="0">
							<tr><th>' . __('One of your sites users package will expire within two days.', 'ct-membership-packages') . '</th></tr>
							<tr>
								<td>' . __('Order ID:', 'ct-membership-packages') . '</td>
								<td>'.$orderID.'</td>
							</tr>
							<tr>
								<td>' . __('Package Name:', 'ct-membership-packages') . '</td>
								<td>'.$packageName.'</td>
							</tr>					
							<tr>
								<td>' . __('Package Expire Date:', 'ct-membership-packages') . '</td>
								<td>'.$packageExpiredate.'</td>
							</tr>
							<tr>
								<td>' . __('User Email:', 'ct-membership-packages') . '</td>
								<td>'.$usermail.'</td>
							</tr>
							<tr><td>' . __('No need for any action this is just a notification.', 'ct-membership-packages') . '</td></tr>	
						</table>';
				
				$headers = 'From: No Reply <noreply@' . $_SERVER['HTTP_HOST'] . '>';
			    $headers .= 'MIME-Version: 1.0';
			    $headers .= 'Content-Type: text/html; charset=UTF-8';

				wp_mail( $to, $subject, $body, $headers );
			}
	}    
}
 // unschedule event upon plugin deactivation
if(!function_exists('ct_packagesCron_deactivate')) {
	function ct_packagesCron_deactivate() {
		wp_clear_scheduled_hook('ct_packagesCron');
		//wp_unschedule_event ($timestamp, 'mycronjob');
	}
}
register_deactivation_hook (__FILE__, 'ct_packagesCron_deactivate'); 
?>