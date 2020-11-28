<?php
/**
 * Date: 11/19/20
 * Time: 5:24 PM
 */

namespace Elhelper\shortcode;


use Elhelper\inc\HelperShortcode;
use Elhelper\model\BhhsModel;

class ListingPriceShortcode {

	public function __construct() {
		add_shortcode( 'summit_listing_price', [ $this, 'summit_listing_price_shortcode' ] );
		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ] );
		add_action( "wp_ajax_search_bhhs_form", [ $this, "get_price_zestimate" ] );
		add_action( "wp_ajax_nopriv_search_bhhs_form", [ $this, "get_price_zestimate" ] );
	}

	public function get_price_zestimate(){
		$res=[];
		
		
		
		
		echo json_decode($res);
		wp_die();	
	
	}

	/**
	 * @param $hook
	 */
	function enqueue_script( $hook ) {
		wp_enqueue_script( 'elhelper-shortcode-js', plugins_url( '/assets/listingprice/js/listingprice-plugin.js', __FILE__ ), array( 'jquery' ) );
	}

	/**
	 * @param $hook
	 */
	function enqueue_style( $hook ) {
//		wp_enqueue_style( 'elhelper-shortcode-css', plugins_url( '/assets/listingprice/css/listingprice-plugin.css', __FILE__ ) );
	}

	function summit_listing_price_shortcode( $atts = [], $content = null ) {


		$get_queried_object = get_queried_object();
		if ( $get_queried_object->post_type == 'listings' ) {

			$bhhs = new BhhsModel( HelperShortcode::convertAddressToUrl( $get_queried_object->post_title ) );
			$res  = $bhhs->getPrice();
		} else {
			echo 'Not in listings detail page';
		}
		if ( empty( $res ) ) {
			$res = 'Not found';
		}

		return $res;
	}


}