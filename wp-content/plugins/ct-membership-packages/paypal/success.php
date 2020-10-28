<?php

global $ct_options;
global $wpdb;
include('../CreateOrder.php');

$_REQUEST = (array)$_REQUEST;

$current_user = wp_get_current_user();

$getdata = get_user_meta($current_user->ID, 'package-data', true);

// $datablock = json_encode($_REQUEST);
// update_user_meta($current_user->ID, 'package-data-success' , $datablock);
// $_REQUEST = get_user_meta($current_user->ID, 'package-data-success', true);

$alldata = (array) json_decode($getdata);
$CreateOrder = new CreateOrder();
$order_id = $CreateOrder->getRequiredContents($alldata);
$order_id = $CreateOrder->getRequiredContents($alldata,$order_id );
update_post_meta($order_id, item_number,  $order_id);
update_post_meta($order_id, payment_status, $_REQUEST['st']);
update_post_meta($order_id, transistions_id,  $_REQUEST['tx']);
update_post_meta($order_id, payment_user_firstname,  $current_user->user_firstname);
update_post_meta($order_id, payment_user_email,  $current_user->user_email);
update_post_meta($order_id, payment_user_lastname,  $current_user->user_lastname);

$user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';

$item_name = get_post_meta($order_id, 'package_name', true);	
$payment_status = get_post_meta($order_id, 'payment_status', true);	
$first_name = get_post_meta($order_id, 'payment_user_firstname', true);	
$last_name =  get_post_meta($order_id, 'payment_user_lastname', true);	
$payer_email = get_post_meta($order_id, 'payment_user_email', true);	
$txn_id =  get_post_meta($order_id, 'transistions_id', true);	
$payment_gross = get_post_meta($order_id, 'paypal_payment_amount', true);	
$payment_method = 'Paypal';	
$admin_email = get_option('admin_email');	

if($payment_status == 'Completed'){

	$ct_site_title = get_bloginfo('name');

	$to = array($admin_email,$payer_email);
	$subject = __('Thanks for your Purchase! Package Order from', 'ct-membership-packages') . ' ' . $ct_site_title;
	$body = '<table border="0">
				<tr><th>' . __('Order Details', 'ct-membership-packages') . '</th></tr>
				<tr>
					<td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
					<td>' . __('Paypal', 'ct-membership-packages') . '</td>
				</tr>
				<tr>
					<td>' . __('Name:', 'ct-membership-packages') . '</td>
					<td>'.$item_name.'</td>
				</tr>
				<tr>
					<td>' . __('Amount:', 'ct-membership-packages') . '</td>
					<td>'.$payment_gross.'</td>
				</tr>
				<tr>
					<td>' . __('Payment Status:', 'ct-membership-packages') . '</td>
					<td>'.$payment_status.'</td>
				</tr>
				<tr>
					<td>' . __('User Name:', 'ct-membership-packages') . '</td>
					<td>'.$first_name.' '.$last_name.'</td>
				</tr>
				<tr>
					<td>' . __('User Email:', 'ct-membership-packages') . '</td>
					<td>'.$payer_email.'</td>  
				</tr>
			
			</table>';
	$headers = array('Content-Type: text/html; charset=UTF-8');

	wp_mail( $to, $subject, $body, $headers );
	//echo $body;
	
} ?>
		
<div class="email-data inner-content">
	<div class="response">
		<h3 id="thanks"><?php _e('Thanks for your purchase!', 'contempo'); ?></h3>
		<h5>Order Details</h5>
		<span>Package Name: <?php echo $item_name; ?></span><br />					
		<span>Payment Method: <?php echo $payment_method; ?></span><br />						
		<span>Amount: <?php echo $payment_gross; ?></span><br />
		<span>Payment Status: <?php echo $first_name; ?></span><br />
		<span>User Name: <?php echo $first_name." ".$last_name; ?></span><br />
		<span>User Email: <?php echo $payer_email; ?></span><br />
		<p class="marT20 marB20"><a class="btn" href="<?php echo get_page_link($user_listings); ?>"><?php _e('View Your Listings', 'contempo'); ?></a></p>
	</div>
</div>