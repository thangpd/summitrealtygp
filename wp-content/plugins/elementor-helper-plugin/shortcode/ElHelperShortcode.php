<?php
/**
 * Date: 11/19/20
 * Time: 5:24 PM
 */

class ElHelperShortcode {

	public function __construct() {

		add_shortcode( 'wporgtestsets', [ $this, 'wporg_shortcode' ] );
	}

	function wporg_shortcode( $atts = [], $content = null ) {
		// do something to $content
		// always return
		$content = 'https://www.bhhs.com/home-value';
		$content = 'https://bhhs.findbuyers.com/address/805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308';
		$curl    = curl_init();
//		$proxy = '45.32.106.145:3128';
//		curl_setopt($curl, CURLOPT_PROXY, $proxy);
		curl_setopt ($curl, CURLOPT_URL, $content);
//		curl_setopt( $curl, CURLOPT_FAILONERROR, true );
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec ($curl);
		curl_close ($curl);
		echo '<pre>';
		print_r( $result );
		echo '</pre>';
		die;

		return $content;
	}


}