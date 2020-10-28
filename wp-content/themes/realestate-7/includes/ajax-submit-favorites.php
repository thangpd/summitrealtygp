<?php
/**
 * Ajax Submit - Listing Favorites
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

$email=$_POST['email'];
$name=$_POST['name'];
$message=$_POST['message'];
$youremail=$_POST['ctyouremail'];
$subject=$_POST['ctsubject'];
$ctproperty=$_POST['ctproperty'];
$ctphone=$_POST['ctphone'];

$isValidate = true;

if($isValidate == true){
	$to = "$youremail";
	$subject = "$subject";
	$msg = "$message" . "\n\n" .
	"Phone: $ctphone" . "\n" .
	"Email: $email" . "\n" .
	"Properties: $ctproperty" . "\n" .
	$headers = "From: $name <$email>" . "\r\n" .
		"Reply-To: $email" . "\r\n" .
		"CC: $ct_listing_agent_contact_cc_email_address" . "\r\n" .
		"X-Mailer: PHP/" . phpversion();
	mail ($to, $subject, $msg, "From: $name <$email>");
	echo "true";
} else {
	echo '{"jsonValidateReturn":'.json_encode($arrayError).'}';
}
?>