<?php
/**
 * Ajax Submit - Contact Template Zapier
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

$ct_email = $_POST['email'];
$ct_name = $_POST['name'];
$ct_phone = $_POST['phone'];
$ct_message = $_POST['message'];
$ct_subject = $_POST['ctsubject'];

$ct_zapier_webhook_url = $_POST['ct_zapier_webhook_url'];

$mailstring = 'name=' . $ct_name . '&email=' . $ct_email . '&phone=' . $ct_phone . '&subject=' . $ct_subject . '&message=' . $ct_message;

$ch = curl_init(); 

curl_setopt( $ch, CURLOPT_URL, $ct_zapier_webhook_url );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $mailstring );

$result = curl_exec($ch);

?>