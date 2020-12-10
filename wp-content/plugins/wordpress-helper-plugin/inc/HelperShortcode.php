<?php
/**
 * Date: 11/25/20
 * Time: 3:36 PM
 */

namespace Elhelper\inc;


class HelperShortcode {
	public static function convertAddressToUrl( $address = '' ) {
		if ( ! empty( $address ) ) {
			//805 PEACHTREE ST NE UNIT 416 ATLANTA, GA 30308
			//805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308';

//1325 Peachtree St NE Apt 202, Atlanta GA 30309-3249
//			1325+Peachtree+St+NE+Apt+202-Atlanta-GA-30309
			$res     = explode( ',', $address );
			$res_str = '';
			for ( $i = 0; $i < count( $res ); $i ++ ) {
				if ( $i == 0 ) {
					$res_str .= str_replace( ' ', '+', $res[ $i ] );
				} else {
					$res_str .= str_replace( ' ', '-', $res[ $i ] );
				}
			}

			return $res_str;
		} else {
			return false;
		}
	}

	public static function crawlingData( $address ) {
		// do something to $content
		// always return
//		$content = 'https://www.bhhs.com/home-value';
//		$content = 'https://bhhs.findbuyers.com/address/805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308';
		$curl = curl_init();
//		$proxy = '45.32.106.145:3128';
//		curl_setopt($curl, CURLOPT_PROXY, $proxy);
		curl_setopt( $curl, CURLOPT_URL, $address );
//		curl_setopt( $curl, CURLOPT_FAILONERROR, true );
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec( $curl );
		curl_close( $curl );

		return $result;

	}

}