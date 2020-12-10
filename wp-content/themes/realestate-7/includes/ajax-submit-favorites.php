<?php
/**
 * Ajax Submit - Listing Favorites
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
require_once( "../../../../wp-load.php" );
$email                                     = $_POST['email'];
$name                                      = $_POST['name'];
$message                                   = $_POST['message'];
$youremail                                 = $_POST['ctyouremail'];
$subject                                   = $_POST['ctsubject'];
$ctproperty                                = $_POST['ctproperty'];
$ctphone                                   = $_POST['ctphone'];
$ct_listing_agent_contact_cc_email_address = '';
$isValidate                                = true;
if ( $isValidate ) {
	ob_start();
	$to      = "$youremail";
	$subject = "$subject";
	$msg     = "$message" . "\n\n" .
	           "Phone: $ctphone" . "\n" .
	           "Email: $email" . "\n" .
	           "Properties: $ctproperty" . "\n";
	$headers = "From: $name <$email>" . "\r\n" .
	           "Reply-To: $email" . "\r\n" .
	           "CC: $ct_listing_agent_contact_cc_email_address" . "\r\n" .
	           "X-Mailer: PHP/" . phpversion();
	wp_mail( $to, $subject, $msg, $headers );

	$smtp_debug = ob_get_clean();
	echo $smtp_debug;
	echo "true";
} else {
	$arrayError = '';
	echo '{"jsonValidateReturn":' . json_encode( $arrayError ) . '}';
}
?>