<?php
/**
 * Ajax Submit - Listing Contact Widget
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;
$ct_listing_agent_contact_cc_email_address = isset( $ct_options['ct_listing_agent_contact_cc_email_address'] ) ? esc_html( $ct_options['ct_listing_agent_contact_cc_email_address'] ) : '';

$ct_name = $_POST['name'];
$ct_email = $_POST['email'];
$ct_message = $_POST['message'];
$ct_youremail = $_POST['ctyouremail'];
$ct_subject = $_POST['ctsubject'];
$ct_property = $_POST['ctproperty'];
$ct_permalink = $_POST['ctpermalink'];
$ct_phone = $_POST['ctphone'];

$isValidate = true;

if($isValidate == true){

	$to = "$ct_youremail";
	$subject = "$ct_subject";
	$msg = "$ct_message" . "\n\n" .
	"Phone: $ct_phone" . "\n" .
	"Email: $ct_email" . "\n" .
	"Property Address: $ct_property" . "\n" .
	"Permalink: $ct_permalink" . "\n";
	$headers = "From: $ct_name <$ct_email>" . "\r\n" .
		"Reply-To: $ct_email" . "\r\n" .
		"CC: $ct_listing_agent_contact_cc_email_address" . "\r\n" .
		"X-Mailer: PHP/" . phpversion();
	mail ($to, $subject, $msg, "From: $ct_name <$ct_email>");
	echo "true";

} else {

	echo '{"jsonValidateReturn":'.json_encode($arrayError).'}';

} ?>