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
		add_action( "wp_ajax_get_price_zestimate", [ $this, "get_price_zestimate" ] );
		add_action( "wp_ajax_nopriv_get_price_zestimate", [ $this, "get_price_zestimate" ] );
	}

	public function get_price_zestimate() {
		$res = [];
		if ( isset( $_GET['title'] ) ) {
			$bhhs         = new BhhsModel( HelperShortcode::convertAddressToUrl( $_GET['title'] ) );
			$price        = $bhhs->getPrice();
			$res['price'] = $price;
			echo json_encode( $res );
			wp_die();
		} else {
			echo 'not found title of listing';
		}

	}

	/**
	 * @param $hook
	 */
	function enqueue_script( $hook ) {
		wp_enqueue_script( 'listingprice-shortcode-js', plugins_url( '/assets/listingprice/js/listingprice-plugin.js', __FILE__ ), array( 'jquery' ) );
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

//			$bhhs = new BhhsModel( HelperShortcode::convertAddressToUrl( $get_queried_object->post_title ) );
//			$res  = $bhhs->getPrice();
			$res = <<<HTML
			 <div class="zestimate-price">
			 	<a href="#" class="btn btn-success btn-zestimate">Get Zestimate Price</a>
			 </div>
			
HTML;


		} else {
			echo 'Not in listings detail page';
		}
		if ( empty( $res ) ) {
			$res = 'Not found';
		}

		return $res;
	}


}