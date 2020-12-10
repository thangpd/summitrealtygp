<?php
/**
 * Ajax Submit - Listing Contact Widget Zapier
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

$ct_name = $_POST['name'];
$ct_email = $_POST['email'];
$ct_phone = $_POST['ctphone'];

$ct_selectedDate = $_POST['selectedDate'];
$ct_showing_start = $_POST['showing_start'];
$ct_showing_end = $_POST['showing_end'];

$ct_subject = $_POST['ctsubject'];

$ct_property = $_POST['ctproperty'];
$ct_permalink = $_POST['ctpermalink'];

$ct_agent_name = $_POST['ctagentname'];
$ct_agent_email = $_POST['ctagentemail'];

$ct_zapier_webhook_url = $_POST['ct_zapier_webhook_url'];

$mailstring = 'name=' . $ct_name . '&email=' . $ct_email . '&phone=' . $ct_phone . '&subject=' . $ct_subject . '&date=' . $ct_selectedDate . '&showing_start_time=' . $ct_showing_start . '&showing_end_time=' . $ct_showing_end . '&property=' . $ct_property . '&permalink=' . $ct_permalink . '&agentname=' . $ct_agent_name . '&agentemail=' . $ct_agent_email;

$ch = curl_init(); 

curl_setopt( $ch, CURLOPT_URL, $ct_zapier_webhook_url );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $mailstring );

$result = curl_exec($ch);

?>